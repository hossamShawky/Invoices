<?php

namespace App\Http\Controllers;

use App\Models\{InvoiceDetails,Invoice,InvoiceAttachments};
use Illuminate\Http\Request;

class InvoiceDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function show()

    {
    
  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
        
              $invoice=Invoice::where("id",$id)->first();
              $details = InvoiceDetails::where("invoice_id",$id)->get();
              $attachments = InvoiceAttachments::where("invoice_id",$id)->get();
            return view("invoices.invoice-details",compact("invoice","details","attachments"));
        }
            catch(\Exception $ex)
            {
    //  return $ex;
    return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");
    
            }  
         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceDetails $invoiceDetails)
    {
        //
    }
}
