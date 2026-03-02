<?php

namespace App\Http\Controllers;

use App\Models\subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function createSubscription(Request $request){
        $validated = $request->validate([
            'name'=>'required|string' ,
            
        ]);

         $subscription = new subscription();
         $subscription->name = $validated['name'];
         $subscription->longitude = $validated['longitude'];
         $subscription->latitude = $validated['latitude'];
         $subscription->description = $validated['description'];

        try{
            $subscription->save();
            return response()->json($subscription);

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save Subscriptions' ,
                'message'=>$exception->getMessage()
            ],500);
        }

    }

    public function readAllSubscriptions(){
         try{
            $subscriptions =Subscription::all();
            return response()->json($subscriptions);
        }

        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Subscriptions.',
                'message'=>$exception->getMessage()
            ],500);
        }  
    }  

        public function readSubscription($id){
         try{
            $subscription =Subscription::findOrfail($id);
            return response()->json(['subscription' => $subscription], 200);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Subscriptions.',
                'message'=>$exception->getMessage()
            ],500);
        }
     }

     public function updateSubscription(Request $request,$id){
          $validated = $request->validate([
            'name'=>'required|string' ,
            'description'=>'nullable|string|max:1000' ,
            'longitude'=>'required|string',
            'latitude'=>'required|string'
        ]);
        try{
             $existingSubscription=Subscription::findOrfail($id);
             $existingSubscription->name = $validated['name'];
             $existingSubscription->longitude = $validated['longitude'];
             $existingSubscription->latitude = $validated['latitude'];
             $existingSubscription ->description = $validated['description'];
             $existingSubscription->save();
            return response()->json($existingSubscription);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Subscriptions.',
                'message'=>$exception->getMessage()
            ],500);
         }
     }
    public function deleteSubscription($id) {
    try{  
         $subscription=Subscription::findOrFail($id);
        $subscription->delete();
        return response('Subscription Deleted Successfully!');  
      
    }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Subscriptions.',
                'message'=>$exception->getMessage()
            ],500);      
    }
 }

 
}
