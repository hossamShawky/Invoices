<?php

namespace App\Http\Controllers;

use App\Models\{InvoiceAttachments};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File,Response;
use Auth;
class InvoiceAttachmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

 

public function downloadAttachment($invoiceNumber,$fileName)

{
    $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoiceNumber.'/'.$fileName);
    return response()->download( $contents);
}


 
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        try{  
            $image = $request->file('file_name');
            $file_name = $image->getClientOriginalName();
    
            $attachments =  new InvoiceAttachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $request->invoice_number;
            $attachments->invoice_id = $request->invoice_id;
            $attachments->Created_by = Auth::user()->name;
            $attachments->save();
               
            // move pic
            $imageName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/'. $request->invoice_number), $imageName);
            return redirect()->back()->with("success","    تم   ‘ضافة   مرفق بنجاح      ");

           }

           catch(\Exception $ex)
           {
        // return $ex;
       return redirect()->back()->with("error","خطأ,هناك مشكلة بالموقع    ");
       
           }
    }

   
    public function show($invoiceNumber,$fileName){
    
        try{ 
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()
                ->applyPathPrefix($invoiceNumber.'/'.$fileName);
        return response()->file($files);
    
    }
     
    catch(\Exception $ex)
    {
 //  return $ex;
 return redirect()->back()->with("error","خطأ,هناك مشكلة بالموقع    ");
 
    }
    }

   
    public function edit(InvoiceAttachments $invoiceAttachments)
    {
        //
    }

   
    public function update(Request $request, InvoiceAttachments $invoiceAttachments)
    {
        //
    }

  
    public function destroy(Request $request){
        try {
         $invoice = InvoiceAttachments::findOrFail($request->id_file);
         $invoice->delete();
         Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
         return redirect()->back()->with('success', 'تم حذف المرفق بنجاح');
 
        }
     
        catch(\Exception $ex)
        {
     //  return $ex;
     return redirect()->back()->with("error","خطأ,هناك مشكلة بالموقع    ");
     
        }
     
     
        //
    }
}
