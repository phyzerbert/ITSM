<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;

class UserController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        if($user->role != 'Admin')return back()->with('success', "You can't access to this page.");
        $users = User::paginate(10);
        $current_page = 'user';
        if(null !== $request->get('page')){
            $page_number = $request->get('page');
        }else{
            $page_number = 1;
        }
        
        $data = array(
            'users' => $users,
            'page_number' => $page_number,
            'current_page' => $current_page
        );
        return view('users', $data);
    }
    
    public function profile(Request $request){
        $user = Auth::user();
        $current_page = 'profile';
        
        $data = array(
            'user' => $user,
            'current_page' => $current_page
        );
        return view('profile', $data);
    }

    public function updateuser(Request $request){
        $request->validate([
            'name'=>'required',
            'firstname'=>'required',
            'lastname'=>'required',
            'phone'=>'required',
            'gender'=>'required'
        ]);
        $user = User::find($request->get("id"));
        $user->name = $request->get("name");
        $user->firstname = $request->get("firstname");
        $user->lastname = $request->get("lastname");
        $user->phone = $request->get("phone");
        $user->gender = $request->get("gender");

        if($request->get('newpassword') != ''){
            $user->password = Hash::make($request->get('newpassword'));
        }
        if($request->has("picture")){
            $picture = request()->file('picture');
            $imageName = time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/profile_pictures'), $imageName);
            $user->picture = 'images/profile_pictures/'.$imageName;
        }
        $user->update();
        return back()->with("success", "Updated User Successfully.");
    }

    public function edituser(Request $request){
        $request->validate([
            'name'=>'required',
            'firstname'=>'required',
            'lastname'=>'required',
            'phone'=>'required',
            'gender'=>'required'
        ]);
        $user = User::find($request->get("id"));
        $user->name = $request->get("name");
        $user->firstname = $request->get("firstname");
        $user->lastname = $request->get("lastname");
        $user->phone = $request->get("phone");
        $user->role = $request->get("role");
        $user->gender = $request->get("gender");

        if($request->get('newpassword') != ''){
            $user->password = Hash::make($request->get('newpassword'));
        }
        if($request->has("picture")){
            $picture = request()->file('picture');
            $imageName = time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/profile_pictures'), $imageName);
            $user->picture = 'images/profile_pictures/'.$imageName;
        }
        $user->update();
        return response()->json("success");
    }

    public function create(Request $request){
        // dump($request->all()); die;
        $request->validate([
            'name'=>'required|alpha_dash|unique:users',
            'firstname'=>'required',
            'lastname'=>'required',
            'phone'=>'required',
            'password'=>'required|string|min:6|confirmed'
        ]);
        
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('name'),
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'phone' => $request->get('phone'),
            'role' => $request->get('role'),
            'password' => Hash::make($request->get('password'))
        ]);
        return response()->json('success');
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return back()->with("success", "Deleted Successfully!");
    }
}
