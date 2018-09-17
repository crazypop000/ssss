<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mail;
use App\Jobs\SendWelcomeEmail;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        return view('home');
    }
    
    public function send()
    {
        Log::info("Request cycle without Queues started");
        $this->dispatch(new SendWelcomeEmail());
        Log::info("Request cycle without Queues finished");
    }
}
