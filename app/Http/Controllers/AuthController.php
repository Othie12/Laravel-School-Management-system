<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
       /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

//            $request->session()->regenerate();
/*
        $today = Carbon::now();
        if($period = Period::whereDate('date_from', '<=', $today)->whereDate('date_to', '>=', $today)->first()){
            $request->session()->put('period_id', $period->id);
        }
        $request->session()->put('today', $today);
*/
            return response()->json(Auth::user()->load(['classes', 'class']), 200);
        }

        return response()->json(['error' => 'Wrong contact or password'], 401);
    }

    /**
     * Handle user logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
