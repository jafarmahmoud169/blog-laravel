<?php

namespace App\Http\Controllers;

use App\Models\profile;
use Illuminate\Http\Request;
use Auth;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=Auth::user();
        $id=Auth::id();
        if ($user->profile==null) {
            $profile=profile::create([
                'user_id'=>$id,
                'country'=>'Syria',
                'bio'=>'hello.world!',
                'gender'=>'Male',
                'age'=>18
            ]);
        }
        //return dd($user);
        return redirect()->route('profile.show');
    }
function show(){
$user=Auth::user();
    return view('profile.show')->with('user',$user);
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user=Auth::user();
        $id=Auth::id();
        if ($user->profile==null) {
            $profile=profile::create([
                'user_id'=>$id,
                'country'=>'Syria',
                'bio'=>'hello world',
                'gender'=>'Male',
                'age'=>18
            ]);
        }
        //return dd($user);
        return view('profile.edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'country'=>'required',
            'name'=>'required',
            'gender'=>'required',
            'age'=>'required',
        ]);
        // dd($request);
        $user=Auth::user();
        $user->name=$request->name;
        $user->profile->country=$request->country;
        $user->profile->gender=$request->gender;
        $user->profile->age=$request->age;
        $user->profile->bio=$request->bio;
        $user->save();
        $user->profile->save();
        if ($request->has('password')) {
            $user->password=bcrypt($request->password) ;
            $user->save();
            $user->profile->save();
        }
        //return redirect()->back();
        return redirect()->route('profile')->with('user',$user)->with('success', 'Profile edited succesfully');
    }
}
