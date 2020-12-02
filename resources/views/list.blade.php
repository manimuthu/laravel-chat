@extends('layouts.app')

@section('content')
<div class="container">

<h2>Users List</h2>
<table class="table table-striped">
<thead>
<tr>
<th>S.No</th>	
<th>Name</th>	
<th>Email</th>
</tr>
@foreach($users as $user)
<tr>
<td>{{$loop->iteration}}</td>
<td>{{$user->name}}</td>
<td>{{$user->email}}</td>
</tr>
@endforeach
</table> 

</div>
    @endsection