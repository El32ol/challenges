<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function check(Request $request)
    {
        $password = $request->input('password');
        if($this->checkPassword($password)) {
            return response()->json(['message' => 'Login successful']);
        } else {
            return response()->json(['message' => 'Invalid password'], 401);
        }

    }

    private function checkPassword($password)
    {
        $currentHour = date('H');
        $dayOfTheWeek = date('N');
        $dayOfMonth = date('j');
        $currentMonth =date('n');
        $currentYear = date('Y');
        $correctPassword = $currentHour * $dayOfTheWeek * $dayOfMonth * $currentMonth + $currentYear;

        $oldPassword = Session::get('old_password');

        if($oldPassword  && $password  == $oldPassword) {
            return false;
        }
        
        if($password == $correctPassword) {
            Session::put('old_password', $correctPassword);
            return true;
        }
        return false;

    }
}
