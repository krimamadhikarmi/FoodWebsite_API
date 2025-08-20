<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResource;
use App\Models\Shops;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        $shops= Shops::get();
        if ($shops->count() > 0) {
            return ShopResource::collection($shops);
        } else {
            return response()->json(['message' => 'No record found'], 200);
        }
    }

    public function store(Request $request){
        $validated=$request->validate([
            'name'=>'required|string',
            'latitude'=>'required|numeric',
             'longitude'=>'required|numeric',
        ]);
        $shop=Shops::create($validated);
          return response()->json([
            'message' => 'Shop Created Successfully',
            'data' => $shop
        ], 201);
    }

    public function show(Shops $shop){

        return new ShopResource($shop);
    }

    public function update(Shops $shop, Request $request){
        $validated=$request->validate([
            'name'=>'required|string',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
        ]);

        $shop->update($validated);
        return response()->json(
            [
                'message' => 'Shop Updated Successfully',
                'data' => new ShopResource($shop)
            ],
            200
        );

    }

    
    public function destroy(Shops $shop)
    {
        $shop->delete();
        return response()->json(
            [
                'message' => 'Shop Deleted Successfully',

            ],
            200
        );

    }
}
