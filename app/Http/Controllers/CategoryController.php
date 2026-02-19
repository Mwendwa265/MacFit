<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
         public function createCategory(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|unique:roles,name' ,
            'description'=>'nullable|string|max:1000' ,
        ]);

        $role = new Category();
        $role->name = $validated['name'];
        $role->description = $validated['description'];

        try{
            $role->save();
            return response()->json($role);

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save Categorys' ,
                'message'=>$exception->getMessage()
            ],500);
        }

    }

    public function readAllCategorys(){
         try{
           $category =Category::all();
            return response()->json($category);
        }

        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Categorys.',
                'message'=>$exception->getMessage()
            ],500);
        }  
    }  

        public function readCategory(){
         try{
            $roles =Category::all();
            return response()->json($roles);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Categorys.',
                'message'=>$exception->getMessage()
            ],500);
        }
     }

     public function updateCategory(Request $request,$id){
        $validated=$request->validate([
            'name'=>'required|string|unique:roles,name',
            'description'=>'nulliable|string|max:1000'

        ]);
        try{
            $existingCategory=Category::findOrfail($id);
            $existingCategory->name=$validated['name'];
            $existingCategory->description=$validated['description'];
            $existingCategory->save();
            return response()->json($existingCategory);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Categorys.',
                'message'=>$exception->getMessage()
            ],500);
         }
     }
    public function deleteCategory($id) {
    try{  
         $role=Category::findOrFail($id);
        $role->delete();
        return response('Category Deleted Successfully!');  
      
    }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Categorys.',
                'message'=>$exception->getMessage()
            ],500);      
    }
 }
    
}
    

