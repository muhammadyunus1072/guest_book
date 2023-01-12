<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        return json_encode($request->all());
    }
    public function edit_password(Request $request)
    {
        return json_encode($request->all());
    }
    public function logout(Request $request)
    {
        return json_encode($request->all());
    }
}
