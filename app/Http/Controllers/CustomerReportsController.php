<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Invoice,Section};
class CustomerReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {

    try 
    {
        $sections = Section::all();
        return view("reports.customer-reports",compact("sections"));
    }

    catch(\Exception $ex)
    {
 //  return $ex;
 return redirect()->back()->with("error","خطأ,هناك مشكلة بالموقع    ");
 
    }

    }


    public function searchCustomers(Request $request) {

        try {
            
            // case 1 => section and product no dates

       if($request->Section && $request->product && $request->start_at =='' && $request->end_at ==''){
           
        $invoices = Invoice::where("section_id",$request->Section)
                    ->where("product",$request->product)->get();
        $sections = Section::all();  
        $Section=Section::where("id",$request->Section)->first()->section_name;  
        $product=$request->product;        
       return view('reports.customer-reports',compact('sections','Section','product'))->withDetails($invoices);

            }
// case 2 => section and product and dates
            else{

                $start_at = date($request->start_at);
                $end_at = date($request->end_at);

                // if($start_at > $end_at ) return redirect()->back()->with("error","error");

             $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])
            ->where('section_id','=',$request->Section)
            ->where('product','=',$request->product)->get();
            $sections = Section::all();  
            $Section=Section::where("id",$request->Section)->first()->section_name;  
            $product=$request->product;        
            return view('reports.customer-reports',
            compact('sections','Section','product','start_at','end_at'))->withDetails($invoices);


            }
        }

        catch(\Exception $ex)
        {
     //  return $ex;
     return redirect()->back()->with("error","خطأ,هناك مشكلة بالموقع    ");
     
        }

    }
}
