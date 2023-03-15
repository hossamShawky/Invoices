<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Invoice};
class InvoiceReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
    try {return view("reports.invoice-reports");}

    catch(\Exception $ex)
    {
 //  return $ex;
 return redirect()->back()->with("error","خطأ,هناك مشكلة بالموقع    ");
 
    }

    }


public function searchInvoices(Request $request){

    try {
  
        $searchWay = $request->rdio;

              
// if invoice type => radio =1
if($searchWay == 1 ) { 

    //without dates
     if ($request->type && $request->start_at =='' && $request->end_at =='') {
        $invoices = Invoice::select("*")->where("Status",$request->type)->get();
        $type = $request->type;

 return view('reports.invoice-reports',compact('type'))->withDetails($invoices);

    }
// with dates
    else

    {
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);
        $type = $request->type;
        
        $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
        return view('reports.invoice-reports',compact('type','start_at','end_at'))->withDetails($invoices);
        

    }
}
// user search radio2 => invoice number
else
{
// $invoices = Invoice::where("invoice_number",$request->invoice_number)->get();
                    // Where('fname','LIKE','%'.$q.'%')
if($request->invoice_number !="")                    
$invoices = Invoice::where("invoice_number","LIKE","%".$request->invoice_number."%")->get();
return view('reports.invoice-reports')->withDetails($invoices);

}



    }

    catch(\Exception $ex)
    {
 //  return $ex;
 return redirect()->back()->with("error","خطأ,هناك مشكلة بالموقع    ");
 
    }
}


}
