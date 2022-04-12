<?php

namespace App\Http\Controllers\AdminDoctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        $patients = PatientResource::collection(Patient::whereRole('PATIENT')->latest()->get())->resolve();
        return view('patient.admin-doctor-patients')->with('patients', $patients);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->back()->with('success', "$patient->name has been delete.");
    }

    public function show(Patient $patient)
    {
        //        $patientResource = new PatientResource($patient);
        return view('patient.profile')->with('patient', $patient);
    }

    public function showOwnProfile()
    {
        //        $patientResource = new PatientResource($patient);
        return view('patient.profile')->with('patient', Auth::user()->getUser());
    }


    public function home()
    {

        $patient = Auth::user()->getUser();
        $appointments_upcoming =  $patient->getApprovedAppointment();
        $appointments_pending =  $patient->getPendingAppointment();
        $appointments_completed =  $patient->getDoneAppointment();
        return view(
            'patient.patient-main',
            [
                'appointments_upcoming' => $appointments_upcoming,
                'appointments_pending' => $appointments_pending,
                'appointments_completed' => $appointments_completed,
            ]
        )->with('patient', $patient)->with('doctors', Doctor::whereRole('DOCTOR')->get());
    }
}
