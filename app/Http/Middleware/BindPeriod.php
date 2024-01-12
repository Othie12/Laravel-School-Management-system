<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Period;
use Carbon\Carbon;

class BindPeriod
{
    /**
     * insert the current period into the request
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $today = Carbon::now();
        if($period = Period::whereDate('date_from', '<=', $today)->whereDate('date_to', '>=', $today)->first()){
            //$request->merge(['period_id' => $period->id]);
            $request->merge(['period' => $period]);
        }

        return $next($request);
    }
}
