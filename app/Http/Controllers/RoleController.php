<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
         public function createRole(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|' ,
            'description'=>'nullable|string|max:1000' ,
        ]);

        $role = new Role();
        $role->name = $validated['name'];
        $role->description = $validated['description'];

        try{
            $role->save();
            return response()->json($role);

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save Roles' ,
                'message'=>$exception->getMessage()
            ],500);
        }

    }    
        //   read all roles

    public function readAllRoles(){
         try{
            $roles = Role::all();
            return response()->json($roles);
        }

        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Roles.',
                'message'=>$exception->getMessage()
            ],500);
        }  
    }  

        public function readRole($id){
         try{
            $role =Role::findOrfail($id);
            return response()->json(['role' => $role], 200);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Role.',
                'message'=>$exception->getMessage()
            ],500);
        }
     }  
        //    update role id

     public function updateRole(Request $request,$id){
        $validated = $request->validate([
            'name'=>'required|string|',
            'description'=>'nulliable|string|max:1000'

        ]);
        try{
            $existingRole=Role::findOrfail($id);
            $existingRole->name=$validated['name'];
            $existingRole->description=$validated['description'];
            $existingRole->save();
            return response()->json($existingRole);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to update Roles.',
                'message'=>$exception->getMessage()
            ],500);
         }
     }   

        //  delete role id
    public function deleteRole($id) {
    try{  
         $role=Role::findOrFail($id);
        $role->delete();
        return response('Role Deleted Successfully!');  
      
    }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to delete Role.',
                'message'=>$exception->getMessage()
            ],500);      
    }
 }
    
}


 
