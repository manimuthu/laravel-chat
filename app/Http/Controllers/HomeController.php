<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $uid = Auth::user()->id;
        $users  = User::where('id','!=',$uid)->get(['name','id']);

        $query = "select distinct c.chat_id,u.name, u.id as uid from users u inner join chatting_members c 
        on u.id=c.user_id where u.id!=$uid and c.chat_id in 
        (select chat_id from chatting_members where user_id='$uid') order by u.id";

        $records = DB::select($query);
        $chats = array();
        foreach($records as $data)
        {
            $chats[$data->chat_id]['chat_id'] = $data->chat_id;

            if(isset($chats[$data->chat_id]['uid']))
            $chats[$data->chat_id]['uid'].= ",".$data->uid;
            else
            $chats[$data->chat_id]['uid']= $data->uid;
            
            if(isset($chats[$data->chat_id]['name']))
            $chats[$data->chat_id]['name'].= ", ".$data->name;
            else
            $chats[$data->chat_id]['name']= $data->name;
        }
        // dd($chats);
        return view('home', compact('chats', 'users'));
    }

    public function list()
    {
        $users  = User::latest()->paginate(15);
        return view('list', compact('users'));
    }
}
