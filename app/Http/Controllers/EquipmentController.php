<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
      public function createEquipment(Request $request){
        $validated = $request->validate([
            'name'=>'required|string' ,
            'usage'=>'nullable|string|max:1000' ,
            'model_no'=>'required|string',
            'value'=>'required|string',
            'status'=>'required|string'
        ]);

         $equipment = new Equipment();
         $equipment->name = $validated['name'];
         $equipment->usage = $validated['usage'];
         $equipment->model_no= $validated['model_no'];
         $equipment->value = $validated['value'];
          $equipment->status = $validated['status'];
        

        try{
            $equipment->save();
            return response()->json($equipment);

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save Equipments' ,
                'message'=>$exception->getMessage()
            ],500);
        }

    }

    public function readAllEquipments(){
         try{
            $equipments =Equipment::all();
            return response()->json($equipments);
        }

        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Equipments.',
                'message'=>$exception->getMessage()
            ],500);
        }  
    }  

        public function readEquipment($id){
         try{
            $equipment =Equipment::findOrfail($id);
            return response()->json(['equipment' => $equipment], 200);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Equipments.',
                'message'=>$exception->getMessage()
            ],500);
        }
     }

     public function updateEquipment(Request $request,$id){
          $validated = $request->validate([
            'name'=>'required|string' ,
            'description'=>'nullable|string|max:1000' ,
            'longitude'=>'required|string',
            'latitude'=>'required|string'
        ]);
        try{
             $existingEquipment=Equipment::findOrfail($id);
             $existingEquipment->name = $validated['name'];
             $existingEquipment->longitude = $validated['longitude'];
             $existingEquipment->latitude = $validated['latitude'];
             $existingEquipment ->description = $validated['description'];
             $existingEquipment->save();
            return response()->json($existingEquipment);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Equipments.',
                'message'=>$exception->getMessage()
            ],500);
         }
     }
    public function deleteEquipment($id) {
    try{  
         $equipment=Equipment::findOrFail($id);
        $equipment->delete();
        return response('Equipment Deleted Successfully!');  
      
    }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Equipments.',
                'message'=>$exception->getMessage()
            ],500);      
    }
 }
    
}
