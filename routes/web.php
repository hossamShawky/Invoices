<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
                        AdminController,InvoiceController,SectionController,ProductController,
                        InvoiceDetailsController,InvoiceAttachmentsController,
                        InvoiceArchiveController,UserController,InvoiceReportsController,
                        CustomerReportsController};


Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
 
// Dashboard Resources Routes 
Route::resource("invoices",InvoiceController::class);
Route::resource("sections",SectionController::class);
Route::resource("products",ProductController::class);
Route::resource("invoice_attachments",InvoiceAttachmentsController::class);
Route::resource("invoice_archives",InvoiceArchiveController::class);
Route::resource("users",UserController::class);

//special routes
Route::get("/truncate/sections",[SectionController::class,'truncateAll'])->name("truncate.sections");

// Details
Route::get("/section/{id}",[InvoiceController::class,'getSectionProducts']);

// Invoices 
Route::post("/invoice-update",[InvoiceController::class,'update'])->name("invoice.update");
Route::get("/invoice/change/pay/{id}",[InvoiceController::class,"changePayStatus"])
        ->name("invoice.change-status");
Route::post("/invoice/change/pay",[InvoiceController::class,"storePayStatus"])
        ->name("invoice.store-change-status");        
Route::get("/invoice-details/{id}",[InvoiceDetailsController::class,'edit'])
        ->name("invoice.details");

     
Route::get("/printInvoice/{id}",[InvoiceController::class,'printInvoice'])
        ->name("invoice.print");        

Route::post("/invoice-archive/restore",[InvoiceArchiveController::class,"restore"])
        ->name("invoice.archive-restore");  
// Attachments

Route::get("/view-attachment/{invoiceNum}/{fileName}",[InvoiceAttachmentsController::class,"show"])->name("attachments.view-attachment");
Route::get("/download-attachment/{invoiceNum}/{fileName}",[InvoiceAttachmentsController::class,"downloadAttachment"])->name("attachments.download-attachment");
Route::post("/delete-attachment",[InvoiceAttachmentsController::class,"destroy"])->name("attachments.delete-attachment");

// Sections
Route::post("/delete-section",[SectionController::class,"deleteSection"])->name("sections.delete-section");

Route::post("/sections/update",[SectionController::class,"update"])->name("sections.update-section");

// Reports

Route::get("/invoice_reports",[InvoiceReportsController::class,'index'])->name("invoice_reports.index");
Route::post("/search_invoices",[InvoiceReportsController::class,'searchInvoices'])->name("invoice_reports.search_invoices");
 
Route::get("/customer_reports",[CustomerReportsController::class,'index'])->name("user_reports.index");
Route::post("/search_customers",[CustomerReportsController::class,'searchCustomers'])->name("invoice_reports.search_users");
 











Route::get("/testFilter",function(){
         
         $invoiceAttacmetns = \App\Models\Invoice::
          orderBy("id","DESC")->latest()->first()->attachments;
         return view("testFilter",compact("invoiceAttacmetns"));

});
Route::get("/filter/{key}",[SectionController::class,"filter"]);







// Demo
Route::get('/{page}', [AdminController::class,'index']);







// NEW SEARCH

// use Illuminate\Http\Request;
// use App\Models\Invoice;

// Route::post("/searchTEST",function(Request $request){
 
//         // return all invoices
// if($request->invoice_all){
//         $invoices= Invoice::all();
//         return view('reports.invoice-reports')->withDetails($invoices);

// }
//         // return specific 
// else{
// $types =  array();

// foreach ($request->invoice_type as $key => $value) {
//         array_push($types,$value);
// }

// $invoices= Invoice::whereIn("Status",$types)->get();
// return view('reports.invoice-reports')->withDetails($invoices);

// }

// });


