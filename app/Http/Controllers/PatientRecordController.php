<?php

namespace App\Http\Controllers;

use App\Http\Resources\PatientRecordResource;
use App\Models\Appointment;
use App\Models\PatientRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->route('patient_id');

        if($data){
            // doctor and admin access
            $response = PatientRecord::query()->wherePatientId($data)->latest()->get();

        }else {
        //patient can only view own record
            $response = PatientRecord::query()->wherePatientId(Auth::user())->latest();
        }
        return PatientRecordResource::collection($response);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    public function show(PatientRecord $patientRecord)
    {
        return new PatientRecordResource($patientRecord);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
