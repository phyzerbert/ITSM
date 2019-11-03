<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Incident;
use App\Comment;
use App\User;
use Auth;
use App\Exports\IncidentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\IncidentEmail;
use App\Mail\CommentEmail;
use Illuminate\Support\Facades\Mail;

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
            'short_description' => 'required|string',
            'description' => 'required|string',
            'group_id' => 'required',
            'category_id' => 'required',
            'phone' => 'required|numeric'
        ]);
        $user = Auth::user();

        $incident = Incident::create([
            'user_id' => $user->id,
            'group_id' => $request->group_id,
            'category_id' => $request->category_id,
            'phone' => $request->phone,
            'priority' => $request->priority,
            'urgency' => $request->urgency,
            'description' => $request->description,
            'short_description' => $request->short_description,
        ]);
        $incident->update(['reference_number' => str_pad($incident->id, 6, '0', STR_PAD_LEFT)]);
        $admin_email = env('ADMIN_EMAIL');
        $user_email = $user->email;
        Mail::to($admin_email)->send(new IncidentEmail($incident));
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($user_email)->send(new IncidentEmail($incident));
        }
        

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
            $incident_mod = $incident_mod->where(function($query) use($description) {
                return $query->where('short_description', 'like', "%$description%")
                            ->orWhere('description', 'like', "%$description%");
            });
        }

        $incidents = $incident_mod->orderBy('created_at', 'desc')->paginate(10);
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
        if($data['status'] == '2'){
            $incident->resolved_user_id = Auth::user()->id;
            $incident->resolved_at = date('Y-m-d H:i:s');
        }
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
            $opened_at = $request->get('opened_at');
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
        // dump($request->all());
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
            $opened_at = $request->get('opened_at');
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

        $data = $mod->get();
        return Excel::download(new IncidentsExport($data), 'incidents_report.xlsx');
    }

    public function comment(Request $request) {
        $current_page = 'search';
        $id = $request->id;
        $incident = Incident::find($id);
        return view('comment', compact('incident', 'current_page'));
    }

    public function save_comment(Request $request) {
        $request->validate([
            'content' => 'required',
        ]);
        $user = Auth::user();
        $comment = Comment::create([
            'user_id' => $user->id,
            'incident_id' => $request->id,
            'content' => $request->content,
        ]);
        $incident = Incident::find($request->id);
        $admin_email = env('ADMIN_EMAIL');
        $user_email = $user->email;
        Mail::to($admin_email)->send(new CommentEmail($incident, $comment));
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($user_email)->send(new CommentEmail($incident, $comment));
        }
        return back()->with('success', 'Left comment successfully');
    }
    
}
