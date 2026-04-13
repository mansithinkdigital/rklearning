<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('client.index');
    }

    public function about()
    {
        return view('client.about');
    }
    public function course()
    {
        return view('client.courses');
    }

    public function contact()
    {
        return view('client.contact');
    }
}
