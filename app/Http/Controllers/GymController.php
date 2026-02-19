<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;

class GymController extends Controller
{
    public function createGym(Request $request){
        $validated = $request->validate([
            'name'=>'required|string' ,
            'description'=>'nullable|string|max:1000' ,
            'longitude'=>'required|string',
            'latitude'=>'required|string'
        ]);

         $gym = new Gym();
         $gym->name = $validated['name'];
         $gym->longitude = $validated['longitude'];
         $gym->latitude = $validated['latitude'];
         $gym->description = $validated['description'];

        try{
            $gym->save();
            return response()->json($gym);

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save Gyms' ,
                'message'=>$exception->getMessage()
            ],500);
        }

    }

    public function readAllGyms(){
         try{
            $gyms =Gym::all();
            return response()->json($gyms);
        }

        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Gyms.',
                'message'=>$exception->getMessage()
            ],500);
        }  
    }  

        public function readGym($id){
         try{
            $gym =Gym::findOrfail($id);
            return response()->json(['gym' => $gym], 200);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Gyms.',
                'message'=>$exception->getMessage()
            ],500);
        }
     }

     public function updateGym(Request $request,$id){
          $validated = $request->validate([
            'name'=>'required|string' ,
            'description'=>'nullable|string|max:1000' ,
            'longitude'=>'required|string',
            'latitude'=>'required|string'
        ]);
        try{
             $existingGym=Gym::findOrfail($id);
             $existingGym->name = $validated['name'];
             $existingGym->longitude = $validated['longitude'];
             $existingGym->latitude = $validated['latitude'];
             $existingGym ->description = $validated['description'];
             $existingGym->save();
            return response()->json($existingGym);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Gyms.',
                'message'=>$exception->getMessage()
            ],500);
         }
     }
    public function deleteGym($id) {
    try{  
         $gym=Gym::findOrFail($id);
        $gym->delete();
        return response('Gym Deleted Successfully!');  
      
    }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Gyms.',
                'message'=>$exception->getMessage()
            ],500);      
    }
 }
}
