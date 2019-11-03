<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Incident;
use App\Mail\IncidentEmail;
use Illuminate\Support\Facades\Mail;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function check_email(){
        $incident = Incident::find(15);
        Mail::to('xian1017@outlook.com')->send(new IncidentEmail($incident));
        return view('email.incident', compact('incident'));
    }
}
