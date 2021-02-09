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
        $from = $request->from;
        $to = $request->to;
        $data = $from === null && $to === null ? Transaction::orderBy('created_at', 'DESC')->get():
                Transaction::latest()->whereBetween('date', [$from, $to])->get();
        $pdf = PDF::loadview('pdf', compact('data', 'from', 'to'))->setPaper('a4', 'landscape');
        return $pdf->download('pdf.pdf');
    }

    public function show($id){
        return view('customer_detail', compact('id'));
    }

    public function export_pdf(Request $request){
        $from = $request->from;
        $to = $request->to;
        $data = $from === null && $to === null ? Customer::findOrFail($request->id)->transaction()->latest()->get():
                Customer::findOrFail($request->id)->transaction()->latest()->whereBetween('date', [$from,$to])->get();
        $pdf = PDF::loadview('pdf_customer', compact('data', 'from', 'to'))->setPaper('a4', 'landscape');
        return $pdf->download('pdf_customer.pdf');
    }
}
