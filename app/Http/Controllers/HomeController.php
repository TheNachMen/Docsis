<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $url = env('URL_API');
        //$valor = true;
        //dd($url);
        $http = Http::withoutVerifying();
        $response = $http->get($url.'documentos');
        $documentos = $response->json();
        //dd($documentos);
        return view('documentos.index',compact('documentos'));
    }

    public function documentos(){
        return view ('documentos.index');
    }
}
