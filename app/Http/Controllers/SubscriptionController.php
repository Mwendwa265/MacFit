<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
     public function createSubscription(Request $request){
        $validated = $request->validate([
            'user_id'=>'required|string',
            'bundles_id'=>'required|string'
        ]);

         $subscription = new Subscription();
         $subscription->user_id = $validated['user_id'];
         $subscription->bundles_id = $validated['bundles_id '];
        

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
            'user_id'=>'required|string',
            'bundles_id'=>'required|string'
        ]);
        try{
             $existingSubscription=Subscription::findOrfail($id);
             $existingSubscription->user_id = $validated['user_id'];
             $existingSubscription->bundles_id = $validated['bundles_id '];
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
