<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatMember;
use App\Models\ChatMessage;
use Auth;
use DB;

class ChatController extends Controller
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

    public function store_active_session()
    {
        $uid = Auth::user()->id;
        $users = \App\User::find($uid);
        $users->status = 1;
        $users->save();
    }

    public function remove_active_session()
    {
        $users = \App\User::find($uid);
        $users->status = 0;
        $users->save();
    }

    public function store_chats(Request $request)
    {
        $uid    = Auth::user()->id;

        $to_id  = $request->to_id.",".$uid;
        $users = explode(",", $to_id);

        $message = $request->message;
        
        $chat_id  = $request->chat_id ?? 0;

        if(!$chat_id)
        {

            $chat   = new Chat();
            $chat->save();
            $chat_id = $chat->id;

            foreach($users as $user)
            {
                $ChatMember = new ChatMember();
                $ChatMember->user_id = $user;
                $ChatMember->chat_id = $chat_id;
                $ChatMember->save();
            }
        }

        $chatMsg = new ChatMessage();
        $chatMsg->user_id = $uid;
        $chatMsg->chat_id = $chat_id;
        $chatMsg->message = $message;
        $chatMsg->save();

        return response()->json([
            'id' => $chat_id
        ],200);
    }

    public function fetch_chats(Request $request)
    {
        $uid    = Auth::user()->id;

        $chat_id  = $request->chat_id;

        $query = "select u.id as uid, u.name,c.message,c.created_at from users u inner join chat_messages c on u.id=c.user_id 
        where c.chat_id=$chat_id";

        $messages = DB::select($query);
        
        $view = view('chats', compact('messages', 'uid'))->render(); 
        $new_user_chats = $this->fetch_new_user_chats();
        return response()->json([
            'chats' => $new_user_chats,
            'html' => $view
        ],200);
    }

    public function fetch_new_user_chats()
    {
        $uid    = Auth::user()->id;

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

        return $chats;
    }
    
}