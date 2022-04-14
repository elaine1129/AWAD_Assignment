<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected $fields = [
        'from' => '',
        'to' => '',
        'doctor_ids' => [],
    ];

    private function generateSchedule(Request $request)
    {
        $data = $request->validate([
            'from' => 'date|required|after:yesterday',
            'to' => 'required|date|after_or_equal:from',
            'doctor_ids' => 'required|array',
            'doctor_ids.*' => 'exists:App\Models\Doctor,id'
        ]);
        $startDate = Carbon::parse($data['from']);
        $endDate = Carbon::parse($data['to']);
        $createdSchedules = [];
        collect(CarbonPeriod::create($startDate, $endDate)->toArray())->map(function ($eachDate) use ($data) {
            User::find($data['doctor_ids'])->each(function ($user) use ($eachDate) {
                if ($user->isDoctor()) {
                    if (!Schedule::checkIfScheduleExists($eachDate, $user->id))
                        Schedule::create([
                            'date' => $eachDate,
                            'doctor_id' => $user->id,
                            'slots' => [
                                1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1
                            ],
                        ]);
                }
            });
        });
        return redirect()->back()->with('success', 'Schedules created.');
    }

    public function showCreateForm()
    {
        return view('admin.schedule.create', $this->fields)->with('doctors', User::whereRole('DOCTOR')->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function viewTimeslot(Request $request, Schedule $schedule)
    {
        return $schedule->getAvailableTimeslot();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->generateSchedule($request);
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
}
