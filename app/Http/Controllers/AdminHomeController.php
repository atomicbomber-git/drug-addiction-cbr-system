<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function show()
    {
        return view("admin_home.show");
    }
}
