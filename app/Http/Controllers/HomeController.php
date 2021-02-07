<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Transaction;
use Psy\Readline\Transient;
use PDF;

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

    public function driver()
    {
        return view('driver');
    }

    public function transaction()
    {
        return view('transaction');
    }

    public function export(Request $request){
        $data = $request->from === null && $request->to === null ? Transaction::orderBy('created_at', 'DESC')->get():
                Transaction::latest()->whereBetween('date', [$request->from, $request->to])->get();
        $pdf = PDF::loadview('pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('pdf.pdf');
    }
}
