@extends('layouts.app')

@section('content')
<div class="container">
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Chat</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">

                <input type='hidden' class='chat_id' id='chat_id' />
                <span class="input-group-addon">
                <button type="button" title="Add Members for Group Chat"
                data-toggle="modal" data-target="#group_chat"> 
                <i class="fa fa-plus" aria-hidden="true"></i> Select Users </button>
                </span> </div>
            </div>
          </div>
          <div class="inbox_chat">

          @foreach($chats as $user)
          
          <div class="chat_list" data-id="{{$user['uid']}}">
              <div class="chat_people">
                <div class="chat_ib">
                  <h5 onclick="fetchUserChat(this,{{$user['chat_id'] ?? 0}},{{$user['uid']}})">{{$user['name']}}</h5>
                </div>
              </div>
            </div>  

        @endforeach

        </div>
</div>
        <div class="mesgs">
          <div class="msg_history">
            <div class="incoming_msg">
            <div class="message_container">

            <!-- Here Message will be filled by Ajax request -->

            </div>

            </div>
            </div>
            <div class="type_msg">
            <div class="input_msg_write">
              <!-- <input type="text" class="write_msg" placeholder="Type a message" autofocus /> -->
              <textarea class="form-control message" placeholder="Type a message" aria-label="With textarea"></textarea>

              <button class="msg_send_btn" type="button">
                  <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>

        
      
      
    </div></div>


    <div class="modal" tabindex="-1" role="dialog" id="group_chat">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Members for chat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
        <select class="form-control" multiple id="group_users_list">
        <option value="" disabled="disabled">Add Member</option>
        @foreach($users as $user)
        <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach
        </select>

        <span>Click control key and select for group of users</span>
        </p>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary" onclick="createGroupChat()">Chat</button>
      </div>
    </div>
  </div>
</div>
    @endsection