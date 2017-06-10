@extends('layouts.admin')

@section('content')
<h3>Users</h3>
<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Username</th>
			<th>Email</th>
			<th>roles</th>
			<th>Created at</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	@foreach($users as $u)
		<tr>
			<td>{{$u->id}}</td>		
			<td>{{$u->name}}</td>
			<td>{{$u->email}}</td>
			<td>
			@foreach($u->roles as $role)
				{{$role->name}}
			@endforeach
			</td>
			<td>{{$u->created_at}}</td>
			<td>
				@if(!$u->hasRole('admin'))
					<form action="{{route('admin.users.assignRole', 'admin')}}" method="POST" class="pull-left">
                        {{ csrf_field() }}
						<input type="hidden" name="user_id" value="{{$u->id}}">						
						<button type='submit' class="btn btn-default pull-left">Make Admin</button>
					</form>
				@endif

				<button disabled class="btn btn-danger pull-right">Delete User</button>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
{{ $users->links() }}
@endsection