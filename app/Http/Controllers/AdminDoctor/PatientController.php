<?php

namespace App\Http\Controllers\AdminDoctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Models\User;
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
       return redirect()->back()->with('success',"$patient->name has been delete.");
    }

    public function show(Patient $patient)
    {
//        $patientResource = new PatientResource($patient);
        return view('patient.profile')->with('patient',$patient);
    }

    public function showOwnProfile()
    {
//        $patientResource = new PatientResource($patient);
        return view('patient.profile')->with('patient',Auth::user()->getUser());
    }

}
