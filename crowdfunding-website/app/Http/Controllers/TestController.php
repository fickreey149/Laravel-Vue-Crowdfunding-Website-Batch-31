<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function poin1()
    {
        return view('verificated');
    }

    public function poin2()
    {
        return view('admin-verificated');
    }
}
