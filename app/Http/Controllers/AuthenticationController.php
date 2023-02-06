<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentication\LoginInputRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function __construct(protected AuthenticationService $service) {
    }
    public function login(LoginInputRequest $request)
    {
        
    }

    public function signup()
    {

    }

    public function logout()
    {

    }

    public function resetPassword()
    {

    }

    public function forgotPassword()
    {

    }
}
