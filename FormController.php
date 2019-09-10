<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{

    public function formView()
    {
        return view("form");
    }

    public function formPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);


        if ($validator->passes()) {


            return response()->json(['success'=>'Added new records.']);
        }


        return response()->json(['error'=>$validator->errors()]);
    }

}
