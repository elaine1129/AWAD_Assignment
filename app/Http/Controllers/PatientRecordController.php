<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRecordRequest;
use App\Http\Requests\StorePatientRecordRequest;
use App\Http\Requests\UpdatePatientRecordRequest;
use App\Http\Resources\PatientRecordResource;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PatientRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientRecordController extends Controller
{
    protected $fields = [
        "appointment_id" => '',
        "symptoms" => '',
        "diagnosis" => '',
        "prescription" => ''
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->route('patient_id');

        if ($data) {
            // doctor and admin access
            $response = PatientRecord::query()->wherePatientId($data)->latest()->get();

        } else {
            //patient can only view own record
            $response = PatientRecord::query()->wherePatientId(Auth::user())->latest();
        }
        return PatientRecordResource::collection($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        return view('patient.record.create')->with($data)->with('patient', $patient);
    }

    /**
     * Store a newly created resource in storage.
     * @param PatientRecordRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StorePatientRecordRequest $request)
    {
        PatientRecord::create($request->validated());
        return redirect(route('patient.show', $request->get('patient_id')))->with('success', 'A new record has been added.');
    }

    public function show(PatientRecord $patientRecord)
    {
        return new PatientRecordResource($patientRecord);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatientRecord $patientRecord)
    {
        $data = $patientRecord->toArray();
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $patientRecord->$field);
        }
        return view('patient.record.edit', $data)->with('patient', $patientRecord->patient->getUser())->with('patientRecord', $patientRecord);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRecordRequest $request, PatientRecord $patientRecord)
    {
        $patientRecord->update($request->validated());
        return redirect(route('patient-record.edit', $patientRecord))->with('success', 'Changes saved.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientRecord $patientRecord)
    {
        $patientRecord->delete();
        return redirect(route('patient.show', $patientRecord->patient_id))->with('success', "Patient Record has been deleted");
    }
}
