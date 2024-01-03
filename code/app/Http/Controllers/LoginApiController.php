<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class LoginApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(
        [
            'phone' => 'required|numeric|max:30',
            'phone_code' => 'required|max:10',
        ]);

        $phone = $request->input('phone');
        $phone_code = $request->input('phone_code');

        if(Auth::attempt(['phone' => $phone, 'phone_code' => $phone_code]))
        {
            $user = Auth::user();
            $response['token'] = $user->createToken('ball by ball');
            $response['phone'] = $user->phone;
            $response['phone_code'] = $user->phone_code;

            return response()->json('created successfully', 200);
        }else {

            $data = $request->all();
            $data['phone'] = $data['phone'];
            $data['phone_code'] = $data['phone_code'];
            $user = User::create($data);

            $response['token'] = $user->createToken('ball by ball');
            $response['phone'] = $user->phone;
            
            return response()->json('created successfully', 200);
        }


    }
}
