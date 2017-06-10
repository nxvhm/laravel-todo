{{-- Add New List Modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="addTaskListModal" aria-labelledby="AddTaskList">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create New Task List</h4>
      </div>
      <form class="form-horizontal js-form-submit" role="form" method="POST" action="{{ route('lists.store') }}" id="js-create-list-form">
      <div class="modal-body">
            {{ csrf_field() }}
            <div class="col-xs-12">
              <p class="errorPlaceholder hidden alert alert-danger"></p>
            </div>
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">Name</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" placeholder="The name of the list" required autofocus>
                </div>
            </div>
      </div>
      <div class="modal-footer">

            <button type="submit" class="btn btn-success">Save List</button>            
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>


{{-- Login Modal --}}
@if(Auth::guest())
<div class="modal fade" tabindex="-1" role="dialog" id="loginModal" aria-labelledby="LoginModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Login to your account</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal js-form-submit" role="form" method="POST" data-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}" id="js-login-form">
            {{ csrf_field() }}
            <div class="col-xs-12">
              <p class="errorPlaceholder hidden alert alert-danger"></p>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Password</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>

                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@else 
{{-- Delete Task Modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="deleteTaskModal" aria-labelledby="DeleteTask">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header red">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Task</h4>
      </div>

      <div class="modal-body">
        <h3>Are you sure you want to delete this task ?</h3>
      </div>

      <div class="modal-footer">
          <button type="submit" class="btn btn-danger" id="confirmTaskDelete">Yes, delete task</button>            
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

{{-- Edit Task Modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="editTaskModal" aria-labelledby="Edit Task">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Task</h4>
      </div>

      <div class="modal-body">
        <form action="{{route('tasks.update', 0)}}" method="POST" role="form" id="addTaskForm">
        {{ csrf_field() }}  
        {{ method_field('PUT') }}  
        <input type="hidden" name="list" value="{{ isset($list) && isset($list->id) ? $list->id : null}}">
        <div class="col-xs-12 col-md-7">            
          <div class="form-group">
          <label>Task Name</label>
          <input type="text" name="name" class="form-control" placeholder="Task Name">
          </div>
        </div> 
        <div class="col-xs-12 col-md-5">
          <label>Task Status</label>
        <select class='form-control' name='status'>
          <option value="{{App\Models\Task::NOT_STARTED}}">Not started yet</option>
          <option value="{{App\Models\Task::IN_PROGRESS}}">Working on/In progress</option>
          <option value="{{App\Models\Task::COMPLETED}}">Task is completed</option>
          <option value="{{App\Models\Task::CANCELED}}">Canceled task</option>
        </select>
        </div>  
        <div class="col-xs-12">           
          <div class="form-group">
            <textarea name="desc" class="form-control" placeholder="Task Description(optional)"></textarea>
          </div>
        </div>          
        </form>      
      </div>

      <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="confirmTaskEdit">Update task</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

{{-- Edit List Modal --}}
@if(isset($list))
<div class="modal fade" tabindex="-1" role="dialog" id="editListModal" aria-labelledby="Edit List">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Task List</h4>
      </div>

      <div class="modal-body">
        <form action="{{route('lists.update', ['id' => $list->id])}}" method="POST" role="form" id="editListForm">
        {{ csrf_field() }}  
        {{ method_field('PUT') }}  
        <input type="hidden" name="id" value="{{$list->id}}">
        <div class="col-xs-12 col-md-7">            
          <div class="form-group">
          <label>List Name</label>
          <input type="text" name="name" class="form-control" value="{{$list->name}}">
          </div>
        </div>       
        </form>      
      </div>

      <div class="modal-footer">
          <button type="submit" class="btn btn-success confirmAction" id="confirmAction">Update list</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

{{-- Send delete request for list --}}
<div class="modal fade" tabindex="-1" role="dialog" id="deleteListRequestModal" aria-labelledby="Make Delete Request for List">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header red">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Make Delete Request for List</h4>
      </div>

      <div class="modal-body">
        <h5>Your dont have permissions to delete lists</h5>
        <h4>Do you want to send a delete request for this task list ?</h4>
      </div>

      <div class="modal-footer">
          <button type="submit" class="btn btn-danger confirmAction">Do it</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

{{-- Confirm Modal Delete --}}
<div class="modal fade" tabindex="-1" role="dialog" id="deleteListModal" aria-labelledby=" Delete List">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header red">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete list</h4>
      </div>

      <div class="modal-body">
        <h4>Are your sure you want to delete this task list ?</h4>
        <h5>This process cannot be reverted</h5>
      </div>

      <div class="modal-footer">
          <button type="submit" class="btn btn-danger confirmAction">Do it</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

{{-- Confirm Archivate Action --}}
<div class="modal fade" tabindex="-1" role="dialog" id="archivateModal" aria-labelledby=" Archive List">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Archivate Task List</h4>
      </div>

      <div class="modal-body">
        <h4>Are your sure you want to archivate this task list ?</h4>
        <h5>You cannot edit or delete tasks from archivated task lists.This process cannot be reverted</h5>
      </div>

      <div class="modal-footer">
          <button type="submit" class="btn btn-success confirmAction">Do it</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
@endif



@endif
