<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use Carbon\Carbon;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function resolve(){
        $today = Carbon::now()->year;//First select the year we are in
        $periods = Period::whereYear('date_from', $today)->get();
        /*foreach($periods as $period){
            echo $period->name;
        }*/

        if(count($periods) === 0){
            return $this->create();
        }else{
            return $this->edit($periods);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('periods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $first_begin = $request->first_begin;
        $first_end = $request->first_end;
        $second_begin = $request->second_begin;
        $second_end = $request->second_end;
        $third_begin = $request->third_begin;
        $third_end = $request->third_end;
/*
        $fb = Carbon::parse($request->first_begin);
        $fe = Carbon::parse($request->first_end);
        $sb = Carbon::parse($request->second_begin);
        $se = Carbon::parse($request->second_end);
        $tb = Carbon::parse($request->third_begin);
        $te = Carbon::parse($request->third_end);

        if($fe->isBefore($fb) || $se->isBefore($sb) || $te->isBefore($tb)){
            return redirect()->back()->with('status', 'You have set start date greater than the end date.');
        }elseif($fe->isAfter($sb) || $se->isAfter($tb)){
            return redirect()->back()->with('status', 'Your dates are not realistic.');
        }elseif($currentYear !== $fb->year || $currentYear !== $fe->year || $currentYear !== $sb->year || $currentYear !== $se->year || $currentYear !== $sb->year || $currentYear !== $te->year){
            return redirect()->back()->with('status', 'You can only set calendar for this year.');
        }
*/
        //store terms, begining and end dates in the db
        $term1 = Period::create([
            'name' => 'First term',
            'date_from' => $first_begin,
            'date_to' => $first_end,
        ]);

        $term2 = Period::create([
            'name' => 'Second term',
            'date_from' => $second_begin,
            'date_to' => $second_end,
        ]);

        $term3 = Period::create([
            'name' => 'Third term',
            'date_from' => $third_begin,
            'date_to' => $third_end,
        ]);

        return redirect(route('period'))->with('status', 'successfuly created');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($periods)
    {
        return view('periods.update', ['periods' => $periods]);
    }

    /**
     * Update the specified period in storage.
     */
    public function update(Request $request)
    {
        //select all the periods from the database all periods that share the same year as now
        $today = Carbon::now()->year;
        $periods = Period::whereYear('date_from', $today)->get();

        //update these periods in tha db
        for ($period=0, $start=0, $end=0; $period < count($periods); $period++, $start++, $end++) {
            $periods[$period]->date_from = $request->start[$start];
            $periods[$period]->date_to = $request->end[$end];
            $periods[$period]->save();
        }
        return redirect(route('period'))->with('status', 'successfuly saved');
    }

}
