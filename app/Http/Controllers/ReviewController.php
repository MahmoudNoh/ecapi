<?php

namespace App\Http\Controllers;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Model\Product;
use App\Model\Review;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        //
        return ReviewResource::collection($product->reviews);
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
    public function store(ReviewRequest $request,Product $product)
    {

        $review = new Review($request->all());
        if($product->reviews()->save($review)){

            return response()->json(['status'=>"Successfuly Created Review ", 'data'=>new ReviewResource($review)  ], Response::HTTP_CREATED);

        }
    
        

        return response()->json(['status'=>"There is a problem ", 'data'=>$$review], Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show( Product $product, Review $review )
    {
        //
        
        return new ReviewResource($review);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request,Product $product, Review $review)
    {
        

        if($review->update($request->all())){

            return response()->json(['status'=>"Successfuly Updated Review ", 'data'=>new ReviewResource($review)  ], Response::HTTP_CREATED);

        }

        return response()->json(['status'=>"There is a problem ", 'data'=>$$review], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
   public function destroy(Product $product,Review $review)
    {
        

        if($review->delete()){

            return response()->json(['status'=>"Successfuly Deleted  Review "], Response::HTTP_OK);

        }

        return response()->json(['status'=>"There is a problem ", 'data'=>$$review], Response::HTTP_INTERNAL_SERVER_ERROR);    }
}
