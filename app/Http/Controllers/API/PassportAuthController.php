<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PassportAuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password'
        ]);
        if ($validator->fails()) {
            return $this->sendError('invalide requist',$validator->errors());
        }
        $input=$request->all();
        $input['password']=Hash::make($input['password']);
        $user=User::create($input);
        $success['token']=$user->createToken('gameOfThrones')->accessToken;
        $success['name']=$user->name;
        return $this->sendResponse($success,'user registed succesfully',);
    }
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user=Auth::user();
            $success['token']=$user->createToken('gameOfThrones')->accessToken;
            $success['name']=$user->name;
            return $this->sendResponse($success,'user login succesfully',);
        }
        else {
            return $this->sendError('unauthorised',['error'=>'unauthorised']);
        }
    }
}
