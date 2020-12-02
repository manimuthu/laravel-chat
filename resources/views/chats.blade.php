
@foreach($messages as $message)

@if($message->uid != $uid)
<div class="incoming_msg">
<div class="received_msg">
<div class="received_withd_msg">
<span class="time_date"> {{$message->name}}</span>
    <p>{{$message->message}}</p>
    <span class="time_date"> {{date('M, Y H:i A',strtotime($message->created_at))}}</span>
</div>
</div>
</div>
@else
<div class="outgoing_msg">
    <div class="sent_msg">
    <span class="time_date"> You</span>
    <p>{{$message->message}}</p>
    <span class="time_date"> {{date('M, Y H:i A',strtotime($message->created_at))}}</span>
</div>
</div>

@endif

@endforeach