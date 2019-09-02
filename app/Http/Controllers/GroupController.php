<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Group;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $current_page = 'group';
        $data = Group::all();
        return view('group', compact('data', 'current_page'));
    }
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string',
        ]);

        Group::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Created Successfully!');
    }

    public function edit(Request $request){
        $request->validate([
            'name' => 'required'
        ]);

        $item = Group::find($request->id);
        $item->update(['name' => $request->name]);

        return back()->with('success', 'Updated Successfully!');
    }

    public function delete($id){
        $item = Group::find($id);
        $item->delete();
        return back()->with('success', "Deleted Sucessfully.");
    }

}
