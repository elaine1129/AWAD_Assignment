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
        return view('patient.appointment.create')->with('doctor',$doctor);
    }

    public function patientStore(PatientAppointmentRequest $request)
    {
        $data = $request->validated();
        // check again for available timeslots
        if(Schedule::find($data['schedule_id'])->isSlotAvailable($data['timeslot'])){
            $data['patient_id']= Auth::user()->id;
            $data['status'] = 'PENDING';
            Appointment::create($data);
            return redirect(route('patient.home'))->with('alert', [
                'message'=>'Appointment created, pending for approval.',
                'type'=>'success',
            ]);
        }
        return redirect()->back()->withInput($request->input())->with('alert', [
             'message'=>'Failed to create appointment, the selected time has been booked, please select another time.',
             'type'=>'warning',
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
        if($appointment->status != 'PENDING')
            return redirect()->back()->with('alert', [
                'message'=>'Approved appointment cannot be changed, please contact admin.',
                'type'=>'warning',
            ]);
        return view('patient.appointment.edit', $appointment)->with('doctor',$appointment->doctor->getUser())->with('appointment', $appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function patientUpdate(PatientAppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->validated();

        if($appointment->status != 'PENDING'){
            return redirect()->back()->with('alert', [
                'message'=>'Failed to update appointment.',
                'type'=>'warning',
            ]);
        }

        // check again for available timeslots
        $schedule = Schedule::find($data['schedule_id']);
        if($schedule->isSlotAvailable($data['timeslot']) || $data['timeslot'] == $appointment->getTimeslotIndex()){
            $data['patient_id']= Auth::user()->id;
            $appointment->update($data);
            return redirect()->back()->with('alert', [
                'message'=>'Appointment updated.',
                'type'=>'success',
            ]);
        }
        return redirect()->back()->withInput($request->input())->with('alert', [
            'message'=>'Failed to create appointment, the selected time has been booked, please select another time.',
            'type'=>'warning',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show all appointments by status
     */
    public function showAll(){
        $appointments_upcoming =  AppointmentResource::collection(Appointment::where('status','APPROVED')->get())->resolve();
        $appointments_pending =  AppointmentResource::collection(Appointment::where('status','PENDING')->get())->resolve();
        $appointments_completed =  AppointmentResource::collection(Appointment::where('status','DONE')->get())->resolve();
        return view('admin.admin-appointment',[
            'appointments_upcoming'=>$appointments_upcoming,
            'appointments_pending' => $appointments_pending,
            'appointments_completed' => $appointments_completed,
            ]);
    }

    public function markAsDone(Appointment $appointment)
    {
        $this->authorize('mark-done',$appointment);
        $appointment['status']= 'DONE';
        $appointment->save();
        return redirect()->back()->with('message', 'Appointment mark as completed.');
    }
}
