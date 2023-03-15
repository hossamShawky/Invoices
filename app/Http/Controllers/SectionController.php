<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Requests\{SectionRequest,SectionUpdateRequest};

use Illuminate\Support\Facades\DB;


class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**0
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        try{
        
        $sections=Section::all();
        return view("sections.index",compact("sections"));
    }
        catch(\Exception $ex)
        {
// return $ex;
return redirect("/sections")->with("error","خطأ,هناك مشكلة بالموقع    ");

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
    public function store(SectionRequest $request)
    { 
            try{
                    Section::create([
                        "section_name"=>$request->section_name,
                        "description"=>$request->description,
                        "created_by"=>Auth::user()->name,
            ]);
                   
                    return redirect("/sections")-> with("success","تم إضافة القسم بنجاح");
                 
            }

            catch(\Exception $ex)
                    {
// return $ex;
return redirect("/sections")->with("error","خطأ,هناك مشكلة بالموقع    ");

                    }   

}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionUpdateRequest $request )
    { 

        try{ 
            $id = $request->section_id;


        $section = Section::find($id);
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->section_description,
        ]);

           
            return redirect("/sections")-> with("success","تم تعديل القسم بنجاح");
         
    }

    catch(\Exception $ex)
            {
return $ex;
return redirect("/sections")->with("error","خطأ,هناك مشكلة بالموقع    ");

            }   

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
public function truncateAll(){

    { 
        try{
                Section::truncate();
        return redirect("/sections")->with("success","تم حذف جميع الأقسام بنجاح");
    }
        catch(\Exception $ex)
        {
// return $ex;
return redirect("/sections")->with("error","خطأ,هناك مشكلة بالموقع    ");

        }  
    }

} 




public function deleteSection(Request $request){
    try{
        
Section::where("id",$request->section_id)->delete(); 

return redirect("/sections")-> with("success","تم حذف القسم بنجاح");
     
}

catch(\Exception $ex)
        {
// return $ex;s
return redirect("/sections")->with("error","خطأ,هناك مشكلة بالموقع    ");

        } 
}



public function filter($id){


    // $invoiceAttacmetns = \App\Models\Invoice::
    //       orderBy("id","DESC")->latest()->first()->attachments;
    //      return view("testFilter",compact("invoiceAttacmetns"));


     $invoiceAttacmetns=DB::table('invoice_attachments')
     ->where("invoice_number","LIKE","%".$id."%")
     ->pluck("invoice_number","file_name",);
     
    // $products = DB::table("products")->where("section_id",$id)->pluck("product_name","id");
    return json_encode($invoiceAttacmetns);
}

}
