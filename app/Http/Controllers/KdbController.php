<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kdb;
use App\Category;

class KdbController extends Controller
{
    public function index(Request $request){
        $key = '';
        if ($request->has('key') && $request->has('key') != ""){
            $key = $request->get('key');
            $problems = Kdb::where('problem', 'like', "%$key%")->paginate(10);
        }else{
            $problems = Kdb::paginate(10);
        }

        $current_page = "kdbindex";
        if(null !== $request->get('page')){
            $page_number = $request->get('page');
        }else{
            $page_number = 1;
        }
        $data = array(
            'current_page' => $current_page,
            'page_number' => $page_number,
            'key' => $key,
            'problems' => $problems
        );

        return view('kdb.problem', $data);
    }

    public function solution($id){
        $problem = Kdb::find($id);
        $current_page = "kdbsolution";
        $data = array(
            'current_page' => $current_page,
            'problem' => $problem
        );
        return view('kdb.solution', $data);
    }

    public function create(Request $request){
        $catetory = Category::all();
        $current_page = "kdbcreate";
        $max_id = Kdb::max('id');

        $kb_number = 'KB'.str_pad($max_id+1, 4, '0', STR_PAD_LEFT);
        $data = array(
            'current_page' => $current_page,
            'category' => $catetory,
            'kb_number' => $kb_number
        );
        return view('kdb.create', $data);
    }

    public function save(Request $request){
        $request->validate([
            'problem'=>'required|string',
            'solution'=>'required'
        ]);
        $kb_number = $request->get('kb_number');
        $category_id = $request->get('category');
        $problem = $request->get('problem');
        $solution = $request->get('solution');
        Kdb::create([
            'kb_number' => $kb_number,
            'category_id' => $category_id,
            'problem' => $problem,
            'solution' => $solution
        ]);
        return back()->with('success', 'Create article successfully!');
    }

    public function edit($id){
        $kdb = Kdb::find($id);
        $current_page = "kdbindex";
        $category = Category::all();
        return view('kdb.edit', compact('kdb', 'current_page', 'category'));
    }

    public function update(Request $request){
        $request->validate([
            'problem'=>'required|string',
            'solution'=>'required'
        ]);
        $kdb = Kdb::find($request->get('id'));
        // dump($request->all());die;
        $category_id = $request->get('category');
        $problem = $request->get('problem');
        $solution = $request->get('solution');
        $kdb->category_id = $category_id;
        $kdb->problem = $problem;
        $kdb->solution = $solution;
        $kdb->save();

        return back()->with('success', 'Changed article successfully!');
    }

    public function delete($id){

        $kdb = Kdb::find($id);
        $kdb->delete();

        return back()->with('success', 'Changed article successfully!');
    }
}
