<?php

namespace App\Http\Controllers\Tramite;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('homeModulos');
    }

    public function tramite()
    {
        return view('home');
    }
    
}