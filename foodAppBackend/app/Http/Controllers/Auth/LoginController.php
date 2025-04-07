<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\LoginViewResponse;

class LoginController extends Controller
{
    /**
     * Show the login view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => route('password.request'),
            'status' => session('status'),
            'redirect' => $request->query('redirect'),
        ]);
    }
}
