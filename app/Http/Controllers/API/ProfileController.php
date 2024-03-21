<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\profile;
use App\Http\Resources\Profile as ProfileResources;
use App\Http\Resources\User as UserResources;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\API\BaseController as BaseController;

class ProfileController extends BaseController
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
                'age' => 18
            ]);
        }
        //return dd($user);
    }


    function myProfile()
    {
        $user = Auth::user();
        $this->index($user->id);
        //return dd($user->profile);
        return $this->sendResponse(new UserResources($user), 'your profile');
    }



    function userProfile($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return $this->sendError('user not found');
        }
        $this->index($user->id);
        return $this->sendResponse(new UserResources($user), 'user profile');
    }



    public function update(Request $request)
    {
        // $this->validate($request, [
        //     'country' => 'required',
        //     'name' => 'required',
        //     'gender' => 'required',
        //     'age' => 'required',
        // ]);
        // dd($request);
        $user = Auth::user();
        $this->index($user->id);
        if($request->has('name')) $user->name = $request->name;
        if($request->has('country'))$user->profile->country = $request->country;
        if($request->has('gender'))$user->profile->gender = $request->gender;
        if($request->has('age'))$user->profile->age = $request->age;
        if($request->has('bio'))$user->profile->bio = $request->bio;
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        $user->profile->save();
        return $this->sendResponse(new UserResources($user), 'your profile after update');
    }
}
