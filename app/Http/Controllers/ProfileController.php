<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tag;
use App\Models\profile;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $user = User::find($id);
        if ($user->profile == null) {
            $profile = profile::create([
                'user_id' => $id,
                'country' => 'Syria',
                'bio' => 'hello.world!',
                'gender' => 'Male',
                'age' => 18,
                'photo' => 'profilenophoto.jfif'
            ]);
        }
    }
    function show()
    {
        $tags = Tag::all();
        $user = Auth::user();
        $this->index($user->id);
        return view('profile.show')->with('user', $user)->with('tags', $tags);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $tags=Tag::all();
        $user = Auth::user();
        $id = Auth::id();
        if ($user->profile == null) {
            $profile = profile::create([
                'user_id' => $id,
                'country' => 'Syria',
                'bio' => 'hello world',
                'gender' => 'Male',
                'age' => 18,
                'photo' => 'profilenophoto.jfif'
            ]);
        }
        //return dd($user);
        return view('profile.edit')->with('user', $user)->with('tags', $tags);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'country' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required',
        ]);
        // dd($request);
        $user = Auth::user();
        $user->name = $request->name;
        $user->profile->country = $request->country;
        $user->profile->gender = $request->gender;
        $user->profile->age = $request->age;
        $user->profile->bio = $request->bio;
        $user->save();
        $user->profile->save();
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
            $user->save();
            $user->profile->save();
        }
        if ($request->has('photo')) {
            $photo = $request->photo;
            $nphoto = time() . "." . $photo->getClientOriginalExtension();
            $photo->move('images/profiles', $nphoto);
            $user->profile->photo = $nphoto;
            $user->profile->save();
        }
        $user->profile->tags()->sync($request->tags);
        return redirect()->route('profile.show')->with('user', $user)->with('success', 'Profile edited succesfully');
    }
}
