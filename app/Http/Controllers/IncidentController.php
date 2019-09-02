<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Incident;
use App\User;
use Auth;
class IncidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){
        $current_page = 'create';
        $data = array(
            'current_page' => $current_page
        );
        return view('home', $data);
    }
    public function create(Request $request){
        $request->validate([
            'description' => 'required|string',
            'phone' => 'required|numeric'
        ]);
        $user = Auth::user();
        $phone = $request->get('phone');
        $urgency = $request->get('urgency');
        $description = $request->get('description');

        Incident::create([
            'user_id' => $user->id,
            'phone' => $phone,
            'urgency' => $urgency,
            'description' => $description,
        ]);

        return back()->with('success', 'Create Incident Successfully!');
    }

    public function search(Request $request){
        $user_mod = new User();
        $username = $firstname = $lastname = $phone =  $description ='';
        $urgency = [1,1];
        // dump($request->all());die;
        if ($request->has('username') && $request->get('username') != ""){
            $username = $request->get('username');
            $user_mod = $user_mod->where('name', 'like', "%$username%");
        }
        if ($request->has('firstname') && $request->get('firstname') != ""){
            $firstname = $request->get('firstname');
            $user_mod = $user_mod->where('firstname', 'like', "%$firstname%");
        }
        if ($request->has('lastname') && $request->get('lastname') != ""){
            $lastname = $request->get('lastname');
            $user_mod = $user_mod->where('lastname', 'like', "%$lastname%");
        }

        $user_id_array = $user_mod->pluck('id');
        $incident_mod = new Incident();
        $incident_mod = $incident_mod->whereIn('user_id', $user_id_array);
        $urgency = ["off","off"];
        if($request->has('urgency_high') && $request->has('urgency_low')){
            $urgency = ["on","on"];
        }else{
            if ($request->has('urgency_low')){
                $urgency[0] = $request->get('urgency_low');
                $incident_mod = $incident_mod->where('urgency', 0);
            }
            if ($request->has('urgency_high')){
                $urgency[1] = $request->get('urgency_high');
                $incident_mod = $incident_mod->where('urgency', 1);
            }
        }

        if ($request->has('phone') && $request->get('phone') != ""){
            $phone = $request->get('phone');
            $incident_mod = $incident_mod->where('phone', 'like', "%$phone%");
        }

        if ($request->has('description') && $request->get('description') != ""){
            $description = $request->get('description');
            $incident_mod = $incident_mod->where('description', 'like', "%$description%");
        }

        $incidents = $incident_mod->paginate(10);
        // dump($incidents);
        $current_page = 'search';
        if(null !== $request->get('page')){
            $page_number = $request->get('page');
        }else{
            $page_number = 1;
        }
        $data = array(
            'current_page' => $current_page,
            'page_number' => $page_number,
            'incidents' => $incidents,
            'username' => $username,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'urgency' => $urgency,
            'phone' => $phone,
            'description' => $description
        );
        return view('search', $data);
    }

    public function delete($id){
        $incident = Incident::find($id);
        $incident->delete();
        return back()->with('success', "Deleted incident sucessfully.");
    }

    public function response(Request $request){
        $incident = Incident::find($request->get('id'));
        $data = $request->all();
        $incident->status = $data['status'];
        $incident->comment = $data['comment'];
        $incident->save();
        return back()->with('success', 'Response successfully.');
    }
}
