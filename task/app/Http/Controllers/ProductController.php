<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Http\Client\ResponseSequence;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return response()->json(['data' => $product, 'success' => 1], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'price'=>'required',
                'description'=> 'required',
                
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $image = "";
        if ($request->hasFile('image')) {

            $photo  = date('Ymdhis') . '.' . $request->file('image')->getClientOriginalExtension();

            if ($request->file('image')->move(public_path() . '/image/', $photo)) {

                $image = '/image/' . $photo;
            }
        }




        $product = new Product();
        $product->title = $request->get('title');
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->image = $image;
        $product->Save();

        return response()->json(['data' => 'Successfully  added', 'success' => 1], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $product = Product::find($id);
        return response()->json(['data' => $product, 'success' => 1], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json(['data' => $product, 'success' => 1], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

    
        $image = "";

        if ($request->hasFile('image')) {

            $photo  = date('Ymdhis') . '.' . $request->file('image')->getClientOriginalExtension();

            if ($request->file('image')->move(public_path() . '/image/', $photo)) {

                $image = '/image/' . $photo;
            }
        }

        $product->title = $request->get('title');
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->image = $image;
        $product->Save();

        return response()->json(['data' => 'Successfully  Updated', 'success' => 1], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::destroy($id);
        return response()->json(['data' => "successfully Deleted", 'success' => 1], 200);
    }
}
