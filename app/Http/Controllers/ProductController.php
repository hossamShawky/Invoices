<?php

namespace App\Http\Controllers;

use App\Models\{Product,Section};
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;


class ProductController extends Controller
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
        
     try{
       
         $sections = Section::all();   
         $products=Product::all(); 
            return view("products.index",compact(["products","sections"]));
         
    }

    catch(\Exception $ex)
            {
// return $ex;
return redirect("/products")->with("error","خطأ,هناك مشكلة بالموقع    ");

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
    public function store(ProductRequest $request)
    {
        
        try{
            Product::create([
                "product_name"=>$request->product_name,
                "description"=>$request->description,
                "section_id"=>$request->section_id,
    ]);
           
            return redirect("/products")-> with("success","تم إضافة المنتج بنجاح");
         
    }

    catch(\Exception $ex)
            {
// return $ex;
return redirect("/products")->with("error","خطأ,هناك مشكلة بالموقع    ");

            }   

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
