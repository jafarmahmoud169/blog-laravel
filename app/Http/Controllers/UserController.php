<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\profile;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::latest()->paginate(10);
        return view('users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("users.create");
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        return redirect()->route('users.index')->with('success', 'user added succesfully');
    }



    function show($id){
        $tags=Tag::all();
        $user = User::find($id);
        if ($user->profile==null) {
            $profile=profile::create([
                'user_id'=>$id,
                'country'=>'Syria',
                'bio'=>'hello.world!',
                'gender'=>'Male',
                'age'=>18,
                'photo'=>'profilenophoto.jfif'
            ]);
        }
        return view('profile.show')->with('user',$user)->with('tags',$tags);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user=User::find($id);
        $posts=Post::where('user_id',$id);
        if ($user->profile->photo != 'noimage.jfif') {
            File::delete('images/profiles/'.$user->profile->photo);
        }
        // if ($posts->photo != 'noimage.jfif') {
        //     File::delete('images/'.$posts->photo);
        // }
        $posts->delete();
        $user->profile()->delete();
        $user->delete();
        return redirect()->route('users.index')->with('success', 'user deleted succesfully');
    }
}
