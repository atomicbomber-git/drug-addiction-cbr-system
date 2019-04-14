<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModeController extends Controller
{
    public function switch()
    {
        if (session('mode-customer')) {
            session()->forget('mode-customer');
            return redirect(route('admin-home.show'));
        }
        else {
            session(['mode-customer' => TRUE]);
            return redirect(route('guest.home'));
        }
    }
}
