<?php

namespace App\Http\Controllers;
use App\Jobs\SendEmailJob;
use App\Models\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */

   
    public function index()
    {
        return shop::select(['id','name','email','descirption','created_at'])->get();
    }

  
    public function store(Request $request)
    {
        try 
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'descirption' => 'required|max:255',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 400);
            }
    
            $shop = new Shop($request->all());
            $shop->save();
    
            return response()->json([
                'status' => 1,
                'msg' => 'Shop saved successfully',
            ]);
        } 

        catch (ValidationException $e) 
        {
            return response()->json([
                'status' => 0,
                'msg' => 'Validation error',
                'errors' => $e->errors(),
            ], 400);
        } 
    }

    
    
   
    public function update(Request $request, $id)
    {
        try 
            {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required',
                    'descirption' => 'required|max:255',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 0,
                        'msg' => 'Validation error',
                        'errors' => $validator->errors(),
                    ], 400);
                }

                $shop = Shop::findOrFail($id);
                $shop->update($request->all());

                return response()->json([
                    'status' => 1,
                    'msg' => 'Shop updated successfully',
                ]);
            } 
        catch (ValidationException $e) 
            {
              
                return response()->json([
                    'status' => 0,
                    'msg' => 'Validation error',
                    'errors' => $e->errors(),
                ], 400);
            } 
    }

   
    public function destroy($id)
    {
        $shop = shop::findOrFail($id);
        $shop->delete();
        return response()->json(
            [
                'status' => 1,
                'msg' =>  'deleted succefully',
            ]
        );
        
    }

     //This Function will send email in the background 
     public function sendEmails()
     {
         SendEmailJob::dispatch();
 
         return response()->json(['message' => 'Emails sent successfully']);
     }
}
