<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPeriodId
{
    /**
     * Middleware to prevent users from accessing some pages that only need to
     * be altered between the study term
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*Removing this because I haven't yet handled session logic
        if(!$request->session()->has('period_id') || empty($request->session()->get('period_id'))){
            return redirect()->back()->with('status', 'You can only visit this page before the term ends');
        }
        */
        if(!$request->has('period') || empty($request->get('period'))){
            return response()->json(['error' =>'You can only access this page in the middle of the term'], 401);
        }
        return $next($request);
    }
}
