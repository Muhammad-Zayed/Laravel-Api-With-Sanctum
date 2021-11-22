<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(){
        $this->middleware('auth:sanctum' , ['except'=>['index' , 'show']]);
    }

    public function index()
    {
       return response()->json([
        'msg'=>'Success',
        'Products'=>Product::all(),
        'status'=>200
    ]);
    }


    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());
        return response()->json([
            'msg'=>'Product Added Successfully!',
            'Product'=>$product,
            'status'=>201
        ]);
    }

    public function search($name = NULL)
    {
        
        $products = ($name
        ? Product::where('name' , 'like' , '%'.$name.'%')->get()
        : Product::all());

        return response()->json([
            'msg'=> (!$products->isEmpty() ? 'Success' : 'No Products Match'),
            'Products'=>$products,
            'status'=>200
        ],200);
    }

    public function show($id)
    {
        $product = Product::find($id);
        
        if(!$product)
            return response()->json([
                'msg'=>'Product Not Found',
                'status'=>404
            ],404);

        return response()->json([
            'msg'=>'Success',
            'Product'=>$product,
            'status'=>200
        ],200);
    }

 
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        
        if(!$product)
            return response()->json([
                'msg'=>'Product Not Found',
                'status'=>404
            ],404);

        $product->update($request->all());

        return response()->json([
            'msg'=>'Product Updated Successfully!',
            'Product'=>$product,
            'status'=>200
        ],200);
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        
        if(!$product)
            return response()->json([
                'msg'=>'Product Not Found',
                'status'=>404
            ],404);
        
        $product->delete();
        return response()->json([
            'msg'=>'Product Deleted Successfully!',
            'status'=>200
        ],200);
    }
}
