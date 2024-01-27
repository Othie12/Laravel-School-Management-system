<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Students;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index($from, $to){
        $data = Payment::where('date_paid', '>=', $from)->where('date_paid', '<=', $to)->get();
        return response()->json($data, 200);
    }

    public function periodIndex(Request $request, string $period_id){
        if($period_id != null && $period_id != ''){
            $period = $period::find($period_id);
        }else if($request->has('period')){
            $period = $request->period;
            $data = Payment::where('date_paid', '>=', $period->date_from)->where('date_paid', '<=', $period->date_to)->get();
            return response()->json($data, 200);
        }else{
            return response()->json(['error' => "Please chose a term"], 200);
        }

    }

    public function store(Request $request, string $student_id){
        $today = Carbon::now();
        $student = Students::find($student_id);
        if($student){
            $stored = Payment::create([
                'student_id' => $student_id,
                'amount' => $request->amount,
                'balance' => $student->balance - $request->amount,
                'reason' => $request->reason,
                'payement_method' => $request->payement_method,
                'date_paid' => $request->date_paid,
                'hash' => Hash::make($request->amount . $request->balance . $student_id . $today->toDateTimeString()),
            ]);
            if($stored){
                $student->balance = $stored->balance;
                $student->save();
            }
        }
        return $stored ? response()->json(['success' => 'Saved succesfuly'], 200) : response()->json(['error' => 'Failed to save succesfuly'], 500);
    }

    public function update(Request $request, string $id){
       $item = Payment::find($id);
       if($item){
        if($request->has('amount')){
            if($student = Students::find($student_id)){
                $item->amount = $request->amount;
                $item->balance = $student->balance - $request->amount;
                $student->balance = $student->balance - $request->amount;
            }
        }
        if($request->has('reason')){
            $item->reason = $request->reason;
        }
        if($request->has('payment_method')){
            $item->payment_method = $request->payment_method;
        }
        if($request->has('date_paid')){
            $item->date_paid = $request->date_paid;
        }
        $item->save();
        return response()->json(['success' => 'Updated succesfuly'], 200);
       }
       return response()->json(['error' => 'Record not found'], 404);
    }

    public function show(string $id){
        $data = Payment::find($id)->load('student');
        return $data ? response()->json($data, 200) : response()->json(['error' => 'Not found'], 404) ;
    }

    public function indexWithClass($from, $to, string $class_id){
        $payments = Payment::where('date_paid', '>=', $from)->where('date_paid', '<=', $to)->get();
        $data = array();
        foreach ($payments as $payment) {
            if($payment->student->class_id == $class_id){
                array_push($data, $payment);
            }
        }
        return response()->json($data, 200);
    }

    public function periodIndexWithClass(Request $request, string $period_id){
        if($period_id != null && $period_id != ''){
            $period = $period::find($period_id);
        }else{
            $period = $request->period;
        }
        $class_id = $request->class_id;
        $payments = Payment::where('date_paid', '>=', $period->date_from)->where('date_paid', '<=', $period->date_to)->get();
        $data = array();
        foreach ($payments as $payment) {
            if($payment->student->class_id == $class_id){
                array_push($data, $payment);
            }
        }
        return response()->json($data, 200);
    }

    public function searchByHash(string $hash){
        $payment = Payment::where('hash', $hash)->first();
        return response()->json($payment, 200);
    }
}
