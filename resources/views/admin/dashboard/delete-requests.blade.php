@extends('layouts.admin')

@section('content')
<h3>Delete requests</h3>
<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>User</th>
			<th>List</th>
			<th>Requested at</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	@foreach($requests as $delRequest)
		<tr>
			<td>{{$delRequest->id}}</td>		
			<td>{{$delRequest->user->name}}</td>
			<td>{{$delRequest->list->name}}</td>
			<td>{{$delRequest->created_at}}</td>
			<td>
				<form action="{{route('admin.deleteRequests.process', ['action' => App\Models\DeleteRequest::APPROVE_ACTION])}}" method="POST" class="pull-left">
	                {{ csrf_field() }}
					<input type="hidden" name="request_id" value="{{$delRequest->id}}">						
					<button type='submit' class="btn btn-success pull-left">Approve Request</button>
				</form>

				<form action="{{route('admin.deleteRequests.process', ['action' => App\Models\DeleteRequest::DECLINE_ACTION])}}" method="POST" class="pull-left">
	                {{ csrf_field() }}
					<input type="hidden" name="request_id" value="{{$delRequest->id}}">						
					<button type='submit' class="btn btn-warning pull-left">Decline Request</button>
				</form>				

			</td>
		</tr>
	@endforeach
	</tbody>
</table>
{{ $requests->links() }}
@endsection