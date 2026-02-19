<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
      public function createBundle(Request $request){
        $validated = $request->validate([
            'name'=>'required|string' ,
            'description'=>'nullable|string|max:1000' ,
            'start_time'=>'required',
            'duration'=>'required',
            'category_id'=>'integer|exists:categories,id'
        ]);

         $bundle = new Bundle();
         $bundle->name = $validated['name'];
         $bundle-> start_time= $validated['start_time'];
         $bundle->duration = $validated['duration'];
         $bundle->description = $validated['description'];
         $bundle->category_id = $validated['category_id'];

        try{
            $bundle->save();
            return response()->json($bundle);

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save Bundles' ,
                'message'=>$exception->getMessage()
            ],500);
        }

    }

    public function readAllBundles(){
         try{
            // $bundles =Bundle::all();
            $bundles=Bundle::join('categories','bunles.category_id','=','categories.id')
                                ->select('bundles.all','categories.name as categories_name')
                                ->get();

            return response()->json($bundles);
        }

        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Bundles.',
                'message'=>$exception->getMessage()
            ],500);
        }  
    }  

        public function readBundle($id){
         try{
            // $bundle =Bundle::findOrfail($id);
          $bundle=Bundle::join('categories','bunles.category_id','=','categories.id')
                                ->select('bundles.*','categories.name as category_name')
                                ->where('bundles.id',$id)
                                ->first();
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Bundles.',
                'message'=>$exception->getMessage()
            ],500);
        }
     }

     public function updateBundle(Request $request,$id){
              $validated = $request->validate([
            'name'=>'required|string' ,
            'description'=>'nullable|string|max:1000' ,
            'start_time'=>'required|dateTime',
            'duration'=>'required|time',
            'category_id'=>'integer|exists:categories,id'
        ]);
        try{
             $existingBundle=Bundle::findOrfail($id);
             $existingBundle->name = $validated['name'];
             $existingBundle-> start_time= $validated['start_time'];
             $existingBundle ->duration = $validated['duration'];
             $existingBundle->description = $validated['description'];
             $existingBundle ->category_id = $validated['category_id'];
             $existingBundle->save();
            return response()->json($existingBundle);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Bundles.',
                'message'=>$exception->getMessage()
            ],500);
         }
     }
    public function deleteBundle($id) {
    try{  
         $bundle=Bundle::findOrFail($id);
        $bundle->delete();
        return response('Bundle Deleted Successfully!');  
      
    }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Bundles.',
                'message'=>$exception->getMessage()
            ],500);      
    }
 }
}
