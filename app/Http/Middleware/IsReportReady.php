<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Grading;
use App\Models\Students;


class IsReportReady
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $sid): Response
    {
        $student = Students::find($sid);
        $grading = Grading::where('class_id', $student->class_id);
        if ($grading === null) {
            return back()->with('status', 'Let the classteacher first set the aggregations for this class');
        }
        return $next($request);
    }
}
