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
            'group_id' => 'required',
            'phone' => 'required|numeric'
        ]);
        $user = Auth::user();
        $phone = $request->get('phone');
        $urgency = $request->get('urgency');
        $description = $request->get('description');

        Incident::create([
            'user_id' => $user->id,
            'group_id' => $request->get('group_id'),
            'phone' => $phone,
            'urgency' => $urgency,
            'description' => $description,
        ]);

        return back()->with('success', 'Created Incident Successfully!');
    }

    public function search(Request $request){
        $user_mod = new User();
        $username = $firstname = $lastname = $phone = $group_id = $description = '';
        $urgency = [];
        // dd($request->all());
        if ($request->get('username') != ""){
            $username = $request->get('username');
            $user_mod = $user_mod->where('name', 'like', "%$username%");
        }
        if ($request->get('firstname') != ""){
            $firstname = $request->get('firstname');
            $user_mod = $user_mod->where('firstname', 'like', "%$firstname%");
        }
        if ($request->get('lastname') != ""){
            $lastname = $request->get('lastname');
            $user_mod = $user_mod->where('lastname', 'like', "%$lastname%");
        }

        $user_id_array = $user_mod->pluck('id');
        $incident_mod = new Incident();
        $incident_mod = $incident_mod->whereIn('user_id', $user_id_array);
        
        if($request->has('urgency') && $request->get('urgency') != ''){
            $urgency = $request->get('urgency');
            $incident_mod = $incident_mod->whereIn('urgency', $urgency);
        }

        if ($request->get('phone') != ""){
            $phone = $request->get('phone');
            $incident_mod = $incident_mod->where('phone', 'like', "%$phone%");
        }

        if ($request->get('group_id') != ""){
            $group_id = $request->get('group_id');
            $incident_mod = $incident_mod->where('group_id', "$group_id");
        }

        if ($request->get('description') != ""){
            $description = $request->get('description');
            $incident_mod = $incident_mod->where('description', 'like', "%$description%");
        }

        $incidents = $incident_mod->paginate(10);
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
            'group_id' => $group_id,
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

    public function report(Request $request){
        $current_page = 'report';
        $mod = new Incident();
        $username = $status = $opened_at = $resolved_at = '';
        if ($request->get('username') != ""){
            $username = $request->get('username');
            $user_array = User::where('name', 'like', "%$username%")->pluck('id');
            $mod = $mod->whereIn('user_id', $user_array);
        }

        if ($request->get('status') != ""){
            $status = $request->get('status');
            $mod = $mod->where('status', $status);
        }

        if ($request->get('opened_at') != ""){
            $opened_at = $request->get('expiry_period');
            $from = substr($opened_at, 0, 10);
            $to = substr($opened_at, 14, 10);
            $mod = $mod->whereBetween('created_at', [$from, $to]);
        }
        
        if ($request->get('resolved_at') != ""){
            $resolved_at = $request->get('resolved_at');
            $from = substr($resolved_at, 0, 10);
            $to = substr($resolved_at, 14, 10);
            $mod = $mod->whereBetween('resolved_at', [$from, $to]);
        }

        $data = $mod->paginate(10);
        return view('report', compact('data', 'current_page', 'username', 'status', 'opened_at', 'resolved_at'));
    }

    public function export(Request $request) {
        dump($request->all());
    }
    
}
