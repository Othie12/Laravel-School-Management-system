<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ValidatePeriod
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentYear = Carbon::now()->year;

        $first_begin = Carbon::parse($request->first_begin);
        $first_end = Carbon::parse($request->first_end);
        $second_begin = Carbon::parse($request->second_begin);
        $second_end = Carbon::parse($request->second_end);
        $third_begin = Carbon::parse($request->third_begin);
        $third_end = Carbon::parse($request->third_end);

        $begin = $request->start;
        $end = $request->end;

        foreach($begin as $b){
            $b = Carbon::parse($b);
            if($currentYear !== $b->year){
                return redirect()->back()->with('status', 'You can only set calendar for this year.');
            }
        }
        foreach($end as $e){
            $e = Carbon::parse($e);
            if($currentYear !== $e->year){
                return redirect()->back()->with('status', 'You can only set calendar for this year.');
            }
        }

        if($first_end->isBefore($first_begin) || $second_end->isBefore($second_begin) || $third_end->isBefore($third_begin)){
            return redirect()->back()->with('status', 'You have set start date greater than the end date.');
        }elseif($first_end->isAfter($second_begin) || $second_end->isAfter($third_begin)){
            return redirect()->back()->with('status', 'Your dates are not realistic.');
        }elseif($currentYear !== $first_begin->year || $currentYear !== $first_end->year || $currentYear !== $second_begin->year || $currentYear !== $second_end->year || $currentYear !== $third_begin->year || $currentYear !== $third_end->year){
            return redirect()->back()->with('status', 'You can only set calendar for this year.');
        }
        //return redirect()->back()->with('status', 'fb= '. $request->input('first_end') . 'fvv'. $first_begin);

        return $next($request);
    }
}
