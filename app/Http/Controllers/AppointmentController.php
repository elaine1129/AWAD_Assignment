<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;

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
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            ''
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
}
