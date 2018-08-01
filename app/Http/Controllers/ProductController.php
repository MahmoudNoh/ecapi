<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\ProductNotBelongsToUser;



class ProductController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

         //return ProductResource::collection(Product::paginate(20));
         
         return ProductCollection::collection(Product::paginate(20));
        


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
        $product = new Product;
        $product->name = $request->name;
        $product->detail = $request->description;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->user_id = $request->user()->id;



         if($product->save()){
            return response()->json(['status'=>"Successfuly Created Product ", 'data'=>$product], Response::HTTP_CREATED);
         }

        return response()->json(['status'=>"There is a problem ", 'data'=>$product], Response::HTTP_INTERNAL_SERVER_ERROR);

      
     
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //

        return new ProductResource($product);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
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
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $this->ProductUserCheck($product);
        $request['detail'] = $request->description;
        unset($request['description']);

        if($product->update($request->all())){
            return response()->json(['status'=>"Successfuly Updated Product ", 'data'=>$product], Response::HTTP_CREATED);
        }

        return response()->json(['status'=>"There is a problem ", 'data'=>$product], Response::HTTP_INTERNAL_SERVER_ERROR);


        /*return response([
            'data' => new ProductResource($product)
        ],Response::HTTP_CREATED);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->ProductUserCheck($product);
       
        if( $product->delete()){
            return response()->json(['status'=>"Successfuly Deleted Product "], Response::HTTP_OK);
        }

        return response()->json(['status'=>"There is a problem ", 'data'=>$product], Response::HTTP_INTERNAL_SERVER_ERROR);

    }



    public function ProductUserCheck($product)
    {
        if (Auth::id() !== $product->user_id) {
            throw new ProductNotBelongsToUser;
        }
    }

}
