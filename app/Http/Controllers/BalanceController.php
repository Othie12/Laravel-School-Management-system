<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balance;

class BalanceController extends Controller
{
    public function store(string $student_id, string $period_id, Request $request){
        $balanceObject = Balance::where('student_id', $student_id)->where('period_id', $period_id)->first();
        if($balanceObject){
            $balanceObject->balance = $request->amount;
            $balanceObject->save();
            return response()->json(['message' => 'Updated succesfuly'], 200);
        }
        $balanceObject = Balance::create([
            'student_id' => $student_id,
            'period_id' => $period_id,
            'balance' => $request->amount,
        ]);
        if($balanceObject){
            return response()->json(['message' => 'Created succesfuly'], 200);
        }
        return response()->json(['error' => 'Failed to create new balance'], 500);
    }
}
