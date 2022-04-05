<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AppointmentResource::collection(User::find(1)->viewAppointments());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patientCreate(Doctor $doctor)
    {
        return view('patient.appointment.create')->with('doctor', $doctor);
    }

    public function patientStore(PatientAppointmentRequest $request)
    {
        $data = $request->validated();
        // check again for available timeslots
        if (Schedule::find($data['schedule_id'])->isSlotAvailable($data['timeslot'])) {
            $data['patient_id'] = Auth::user()->id;
            $data['status'] = 'PENDING';
            Appointment::create($data);
            return redirect(route('patient.home'))->with('alert', [
                'message' => 'Appointment created, pending for approval.',
                'type' => 'success',
            ]);
        }
        return redirect()->back()->withInput($request->input())->with('alert', [
            'message' => 'Failed to create appointment, the selected time has been booked, please select another time.',
            'type' => 'warning',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function patientEdit(Request $request, Appointment $appointment)
    {
        if ($appointment->status != 'PENDING')
            return redirect()->back()->with('alert', [
                'message' => 'Approved appointment cannot be changed, please contact admin.',
                'type' => 'warning',
            ]);
        return view('patient.appointment.edit', $appointment)->with('doctor', $appointment->doctor->getUser())->with('appointment', $appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function patientUpdate(PatientAppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->validated();

        if ($appointment->status != 'PENDING') {
            return redirect()->back()->with('alert', [
                'message' => 'Failed to update appointment.',
                'type' => 'warning',
            ]);
        }
        $flag = false;
        // check again for available timeslots
        $schedule = Schedule::find($data['schedule_id']);
        if ($schedule->isSlotAvailable($data['timeslot']) || $data['timeslot'] == $appointment->getTimeslotIndex()) {
            $data['patient_id'] = Auth::user()->id;
            $appointment->update($data);
            $flag = true;
            // if patient set a new timeslot and a new timeslot is available
            if ($data['timeslot'] != $appointment->getTimeslotIndex()) {
                $flag = false;
                if ($this->updateNewSchedule($appointment, $schedule, $appointment->schedule, $data['timeslot'])) {
                    $flag = true;
                }
            }
        }

        if ($flag == true)
            return redirect()->back()->with('alert', [
                'message' => 'Appointment updated.',
                'type' => 'success',
            ]);

        return redirect()->back()->withInput($request->input())->with('alert', [
            'message' => 'Failed to create appointment, the selected time has been booked, please select another time.',
            'type' => 'warning',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        echo "<script>console.log('destroy');</script>";
        return redirect()->back()->with('success', "Appintment ID $appointment->id has been delete.");
    }

    /**
     * Show all appointments by status
     */
    public function showAdmin()
    {
        $appointments_upcoming =  Appointment::where('status', 'APPROVED')->get();
        $appointments_pending = Appointment::where('status', 'PENDING')->get();
        $appointments_completed =  Appointment::where('status', 'DONE')->get();
        return view('admin.admin-appointment', [
            'appointments_upcoming' => $appointments_upcoming,
            'appointments_pending' => $appointments_pending,
            'appointments_completed' => $appointments_completed,
        ]);
    }

    public function showDoctor()
    {
        $appointments_upcoming =  Appointment::where('status', 'APPROVED')->get();
        $appointments_completed =  Appointment::where('status', 'DONE')->get();
        return view('doctor.doctor-appointment', [
            'appointments_upcoming' => $appointments_upcoming,
            'appointments_completed' => $appointments_completed,
        ]);
    }

    public function markAsDone(Appointment $appointment)
    {
        $this->authorize('mark-done', $appointment);
        $appointment['status'] = 'DONE';
        $appointment->save();
        return redirect()->back()->with('message', 'Appointment mark as completed.');
    }

    public function markAsApproved(Appointment $appointment)
    {
        $appointment['status'] = 'APPROVED';
        $appointment->save();
        return redirect()->back()->with('alert', [
            'message' => 'Appointment approved.',
            'type' => 'success',
        ]);
    }

    public function markAsCompleted(Appointment $appointment)
    {
        $appointment['status'] = 'DONE';
        $appointment->save();
        return redirect()->back()->with('alert', [
            'message' => 'Appointment completed.',
            'type' => 'success',
        ]);
    }

    public function editAppointment(Request $req, Appointment $appointment)
    {
        // Get a doctor available schedule by date
        $data = DB::table('schedules')
            ->where('date', '=', $req->apptDate)
            ->where('doctor_id', '=', $appointment->doctor_id)
            ->first();
        $schedule_id = $data->id;
        $oldSchedule = $appointment->schedule;


        // check again for available timeslots
        $schedule = Schedule::find($schedule_id);
        if ($this->updateNewSchedule($appointment, $schedule, $oldSchedule, $req['timeslot'])) {
            return redirect()->back()->with('alert', [
                'message' => 'Appointment updated.',
                'type' => 'success',
            ]);
        }
        return redirect()->back()->withInput($req->input())->with('alert', [
            'message' => 'Failed to update appointment, the selected time has been booked, please select another time.',
            'type' => 'warning',
        ]);
    }

    private function updateNewSchedule(Appointment $appointment, Schedule $newSchedule, Schedule $oldSchedule, $newTimeslot)
    {
        $oldTimeslot = $appointment->getTimeslotIndex();
        if ($newSchedule->isSlotAvailable($newTimeslot)) {

            if ($newSchedule->id == $oldSchedule->id) {
                $oldSchedule->revertTimeslot($oldTimeslot);
                $oldSchedule->setTimeslot($newTimeslot);
                $appointment['timeslot'] = $newTimeslot;
                $oldSchedule->save();
                $appointment->save();
                return true;
            }

            $appointment['schedule_id'] = $newSchedule->id;
            $appointment['timeslot'] = $newTimeslot;
            $newSchedule->setTimeslot($newTimeslot);
            $oldSchedule->revertTimeslot($oldTimeslot);

            $oldSchedule->save();
            $newSchedule->save();
            $appointment->save();
            return true;
        }
        return false;
    }
}
