<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Invoice;
class InvoiceArchiveController extends Controller
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
      try{   $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.invoices-archive',compact('invoices'));}
    
    catch(\Exception $ex)
    {
    // return $ex;
    return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");
    
        } 
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
        try{
            $id = $request->invoice_id;

            $invoice = Invoice::where("id",$id)->first();
             $invoice->delete();
            return redirect("/invoice_archives")->with("success","تم أرشفة الفاتورة      بنجاح");
            
} 
catch(\Exception $ex)
{
// return $ex;
return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");

    } }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request )
    {

        try{
            $id = $request->invoice_id;

            $invoice = Invoice::withTrashed()->where("id",$id)->restore();
             return redirect("/invoices")->with("success","تم إستعادة الفاتورة      بنجاح");
            
} 
catch(\Exception $ex)
{
// return $ex;
return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");

    }     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{ 
             
$id = $request->invoice_id;

$invoice = Invoice::withTrashed()->where("id",$id)->first();
$invoice->attachments?Storage::disk('public_uploads')->deleteDirectory($invoice->invoice_number):"";
$invoice->forceDelete();
return redirect("/invoice_archives")->with("success","تم حذف الفاتورة المؤرشفة وكل مرفقاتها بنجاح");



         }
        catch(\Exception $ex)
{
// return $ex;
return redirect("/invoice_archives")->with("error","خطأ,هناك مشكلة بالموقع    ");

    }
}
}