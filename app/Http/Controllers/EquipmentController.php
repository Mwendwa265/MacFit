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
            'model_no'=>'required|string|unique:equipment,model_no',
            'value'=>'required|number',
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
            'value'=>'nullable|number' ,
            'status'=>'required|string',
            'model_no'=>'required|string|unique:equipment,model_no',
            'usage'=>'required|string|max:1000',
        ]);

             $existingEquipment=Equipment::findOrfail($id);
             $existingEquipment->name = $validated['name'];
             $existingEquipment->usage = $validated['usage'];
             $existingEquipment->model_no= $validated['model_no'];
             $existingEquipment->value = $validated['value'];
             $existingEquipment->status = $validated['status'];
             $existingEquipment->save();
        try{
             $existingEquipment->save();
            return response()->json([
                'message'=>'Equipment Updated Successfully.'
            ], 200);
            
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
