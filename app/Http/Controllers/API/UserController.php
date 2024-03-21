<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use App\Models\profile;
use App\Models\Post;
use App\Http\Resources\User as UserResources;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class UserController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::latest()->paginate(10);
        return $this->sendResponse(UserResources::collection($users),'ten posts');
    }



    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'c_password'=>'required|same:password'

        ]);
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $profile=profile::create([
            'user_id'=>$user->id,
            'country'=>'Syria',
            'bio'=>'hello.world!',
            'gender'=>'Male',
            'age'=>18
        ]);
        // return $this->sendResponse(new UserResources($user),'user added succesfully',);
        $success['token']=$user->createToken('gameOfThrones')->accessToken;
        $success['user']=$user;
        return $this->sendResponse($success,'user registed succesfully',);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user=User::find($id);
        if (is_null($user)) {
            return $this->sendError('user not found');
        }
        $posts=Post::where('user_id',$id);
        $posts->delete();
        // return dd($user->id);
        $user->profile()->delete();
        $user->delete();
        return $this->sendResponse(new UserResources($user),'user deleted succesfully',);
    }
}
