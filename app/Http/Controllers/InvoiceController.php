<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\{Invoice,Section,InvoiceDetails,InvoiceAttachments};
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    { 
        try{
        
        $invoices=Invoice::all();
        return view("invoices.index",compact("invoices"));

    }

        catch(\Exception $ex)
        {
// return $ex;
return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");

        } 
    }

   
    public function create()
    {
        try{ 
            $sections = Section::all();
        return view("invoices.createInvoice",compact("sections"));}
        catch(\Exception $ex)
        {
// return $ex;
return redirect("/products")->with("error","خطأ,هناك مشكلة بالموقع    ");

        } 
    }

    
    public function store(Request $request)
    {
       try{

        DB::beginTransaction();

        //Insert Main Invoice Data

        $invoiceId = Invoice::insertGetId([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => "2",
            'note' => $request->note,
        ]);

// Insert Details About Invoice
InvoiceDetails::create([
    'invoice_id' => $invoiceId,
    'invoice_number' => $request->invoice_number,
    'product' => $request->product,
    'Section' => $request->Section,
    'Status' => 'غير مدفوعة',
    'Value_Status' => "2",
    'note' => $request->note,
    'user' => Auth::user()->name,
]);

// Insert Attachment Of Invoice



if ($request->hasFile('pic')) {

    $image = $request->file('pic');
    $file_name = $image->getClientOriginalName();
    $invoice_number = $request->invoice_number;

    $attachments = new InvoiceAttachments();
    $attachments->file_name = $file_name;
    $attachments->invoice_number = $invoice_number;
    $attachments->Created_by = Auth::user()->name;
    $attachments->invoice_id = $invoiceId;
    $attachments->save();

    // move pic
    $imageName = $request->pic->getClientOriginalName();
    $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
}


        DB::commit();
        return redirect()->back()-> with("success","تم إضافة الفاتورة بنجاح");

       }
        catch(\Exception $ex)
        {
            DB::rollback();
            return $ex;
return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");

        }   

    }

  
    public function show(Invoice $invoice)
    {
        //
    }
 
    public function edit($id)
    {
        try{
            $sections = Section::all();
            $invoice=Invoice::where("id",$id)->first();
            return view("invoices.editInvoice",compact("invoice","sections"));
    
        }
    
            catch(\Exception $ex)
            {
    // return $ex;
    return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");
    
            }
    }

    
    public function update(Request $request)
    {
        try{     
            $invoice = Invoice::findOrFail($request->invoice_id);
            $invoice->update([ 
                'invoice_Date' => $request->invoice_Date,
                'Due_date' => $request->Due_date,
                'product' => $request->product,
                'section_id' => $request->Section,
                'Amount_collection' => $request->Amount_collection,
                'Amount_Commission' => $request->Amount_Commission,
                'Discount' => $request->Discount,
                'Value_VAT' => $request->Value_VAT,
                'Rate_VAT' => $request->Rate_VAT,
                'Total' => $request->Total,
                'note' => $request->note,
            ]);
            return redirect("/invoices")->with("success","    تم تعديل الفاتورة بنجاح      ");

           
        }
    
            catch(\Exception $ex)
            {
    return $ex;
    return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");
    
            }
    }
 
    public function destroy(Request $request)
    {
try{      
    
$id = $request->invoice_id;

$invoice = Invoice::where("id",$id)->first();
$invoice->attachments?Storage::disk('public_uploads')->deleteDirectory($invoice->invoice_number):"";
$invoice->forceDelete();
return redirect("/invoices")->with("success","تم حذف الفاتورة  وكل مرفقاتها بنجاح");


} 
catch(\Exception $ex)
{
// return $ex;
return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");

} 


    }


public function getSectionProducts($id) {
try{
    $products = DB::table("products")->where("section_id",$id)->pluck("product_name","id");
    return json_encode($products);
}
    catch(\Exception $ex)
    {
//  return $ex;
return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");

    } 
}


public function changePayStatus($id){
    
try{
       $invoice = Invoice::where("id",$id)->first();
       $sections = Section::all();
    return view("invoices.change-pay",compact("invoice","sections"));
}
    catch(\Exception $ex)
    {
 return $ex;
return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");

    }


    
}

// using laravel observes

public function storePayStatus(Request $request){
    try{
            $invoice = Invoice::findOrFail($request->invoice_id);
// case 1
        if ($request->Status === 'مدفوعة') {

            $invoice->update([
                'Value_Status' => "0",
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            InvoiceDetails::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => "0",
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => Auth::user()->name,
            ]);
        }

        else {
            $invoice->update([
                'Value_Status' => "1",
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            InvoiceDetails::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => "1",
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => Auth::user()->name,
            ]);
        }

        return redirect("/invoices")->with("success","    تم تعديل حاله دفع الفاتورة بنجاح      ");

         }
        catch(\Exception $ex)
        {
    //  return $ex;
    return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");
    
        }


}


public function printInvoice($id) {
 try{  
    $invoice = Invoice::where("id",$id)->first();
    return view("invoices.print-invoice",compact("invoice"));

 }
 catch(\Exception $ex)
 {
     DB::rollback();
     return $ex;
return redirect("/invoices")->with("error","خطأ,هناك مشكلة بالموقع    ");

 } 
}
}