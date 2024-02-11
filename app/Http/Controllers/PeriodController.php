<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use Carbon\Carbon;

class PeriodController extends Controller
{
    public function show($name){
        $today = Carbon::now()->year;//First select the year we are in
        $period = Period::whereYear('date_from', $today)->where('name', $name)->first();

        return response()->json($period, 200);
    }

    public function store(Request $request)
    {
        $message = 'Nothing Updated due to server error';
        if($request->has('id')){
            $period = Period::find($request->id);
            $period->date_from = $request->date_from;
            $period->date_to = $request->date_to;
            $message = $period->save() ? $request->name . ' updated succesfuly': 'Error updating ' . $request->period['name'];
        }else{
            Period::create([
                'name' => $request->name,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
            ]);
            $message = $request->name . ' Created succesfuly';
        }
        return response()->json(['message' => $message], 200);
    }
}
