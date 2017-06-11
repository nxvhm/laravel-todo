@extends('layouts.public')

@section('content')

<section class="panel tasks-widget">
	<header class="panel-heading">
      <span class="title pull-left"> 
        <span data-toggle='tooltip' title='Edit List' class="cursor-pointer listTitleEdit">
          <i class="fa fa-edit" 
            data-toggle="modal" 
            data-target="#editListModal"></i>
        </span>
        {{$list->name}}

        <span class="font-size-12 label label-default"><i class="fa fa-clock-o"></i>&nbsp;{{$list->created_at}}</span>
        @if($list->is_archived == 0)
          <span>
            <span class="font-size-12 label label-primary cursor-pointer"
              data-toggle="modal" 
              data-target="#archivateModal">
              <i class="fa fa-archive"></i>&nbsp;Archive List
            </span>
            <form action="{{route('lists.archive')}}" method="POST" class="pull-left">
              {{csrf_field()}}    
              <input type="hidden" name="id" value="{{$list->id}}">          
            </form>
          </span>
        @else
          <span class="font-size-12 label label-default"><i class="fa fa-archive"></i>&nbsp;List is Archived</span>
        @endif          
        @if($list->delete_available == 0 && count($list->deleteRequest))

          {{-- Delete Request Made, wait for approval --}}        
          <span class="label label-warning font-size-12"> 
            <i class="fa fa-remove"></i> Delete Request made. Waiting for approval
          </span>

        @elseif($list->delete_available == 0 && !count($list->deleteRequest))
          
          {{-- Send Delete Request --}}
          <span>
          <span class="label label-warning font-size-12 cursor-pointer"
            data-toggle="modal"
            data-target="#deleteListRequestModal"> 
            <i class="fa fa-remove"></i> Request Delete
          </span>
          <form action="{{route('lists.deleteRequest')}}" method="POST">
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$list->id}}">
          </form>
          </span>

        @elseif($list->delete_available == 1)
          {{-- Delete List --}}
          <span>
          <span class="label label-danger font-size-12 cursor-pointer"
            data-toggle="modal"
            data-target="#deleteListModal"> 
            <i class="fa fa-remove"></i> Delete This list
          </span>
          <form action="{{route('lists.destroy', ['id' => $list->id])}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <input type="hidden" name="id" value="{{$list->id}}">
          </form>
          </span>
            
        @endif
      
      </span>
      @if($list->is_archived == 0)
        <button type="button" class="btn btn-default pull-right toggleHiddenElemBtn" data-target="#addTaskFormContainer"> <i class="fa fa-plus-circle"></i>
      Add Task
      </button>
      @else 
        <span class="label label-danger pull-right">Archived. You cannot add tasks to this list</span>
      @endif
	</header>

	{{-- Add task to list --}}
		<div class="add-task-form hidden mt20" id="addTaskFormContainer">
		<form action="{{route('tasks.store')}}" method="POST" role="form" id="addTaskForm">

		  {{ csrf_field() }}    
      <input type="hidden" name="list_id" value="{{$list->id}}">

      <div class="row">
        
      <div class="col-xs-12 col-md-8">            
      <div class="form-group">
      <label>Task Name</label>
      <input type="text" name="name" class="form-control" placeholder="Task Name">
      </div>
      </div>

      <div class="col-xs-12 col-md-4">
        <div class="form-group">
          <label>Task Status</label>
          <select class='form-control' name='status'>
            <option value="{{App\Models\Task::NOT_STARTED}}">Not started yet</option>
            <option value="{{App\Models\Task::IN_PROGRESS}}">Working on/In progress</option>
            <option value="{{App\Models\Task::COMPLETED}}">Task is completed</option>
            <option value="{{App\Models\Task::CANCELED}}">Canceled task</option>
          </select>
        </div>
      </div>
      </div>
      <div class="row">
  		<div class="col-xs-12">      			
  			<div class="form-group">
  				<textarea name="desc" class="form-control" placeholder="Task Description(optional)"></textarea>
  			</div>
  		</div>
      </div>
      <div class="row">
  		<div class="col-xs-12 col-md-4 col-md-offset-3">
  			<div class="form-group">
          <button class="btn btn-success btn-block">Save Task</button>
        </div>
  		</div> 
      </div>
		</form>
		</div>

  <div class="panel-body">

      <div class="task-content mt20">

          <ul class="task-list">
          	@if(isset($list->tasks) && count($list->tasks))
          	@foreach($list->tasks as $task)
              <li class="">
                  <div class="task-checkbox">
                      <input class="list-child" value="" type="checkbox">
                  </div>
                  <div class="task-title">
                      <span class="task-title-sp">{{$task->name}}</span>
                      <span class="badge badge-sm ">{{date('d M H:i:s Y', strtotime($task->created_at))}}</span>
                      <span class="badge badge-sm status-{{$task->status}}">{{$task->getStatus()}}</span>

                      @if($list->is_archived == 0)
                      <div class="pull-right ">
                          {{-- Edit Task Btn --}}
                          <span data-toggle="tooltip" title="Edit Task">
                            <button class="btn btn-primary btn-sm"
                              data-toggle='modal'
                              data-task-id="{{$task->id}}"
                              data-task-name="{{$task->name}}"
                              data-task-desc="{{$task->desc}}"
                              data-task-status="{{$task->status}}"
                              data-target='#editTaskModal'>
                              <i class="fa fa-pencil"></i>
                            </button>
                          </span>

                          {{-- Delete Task Btn --}}
                          <span data-toggle='tooltip' title="Delete this task">
                            <button class="btn btn-danger btn-sm"
                              data-toggle='modal'
                              data-target='#deleteTaskModal'>
                              <i class="fa fa-trash-o "></i>
                            </button>
                            <form method="POST" action="{{route('tasks.destroy', $task->id)}}" class="hidden">
                              {{ method_field('DELETE') }}
                              {{ csrf_field() }}
                              <input type="hidden" name="list" value="{{$task->list_id}}">
                            </form>
                          </span>
                      </div>
                      @endif
                  </div>
                  @if($task->desc != null)
	                  <div class="task-body text-muted">{{$task->desc}}</div>
                  @endif
              </li>
          	@endforeach
          	@endif
 
              
          </ul>
      </div>

      <div class=" add-task-row">
          {{-- <a class="btn btn-success btn-sm pull-left" href="#">Add New Tasks</a> --}}
          {{-- <a class="btn btn-default btn-sm pull-right" href="#">See All Tasks</a> --}}
      </div>
  </div>
</section>


      <li class="task-dom hidden" data-id="">
          <div class="task-checkbox">
              <input class="list-child" value="" type="checkbox">
          </div>
          <div class="task-title">
              <span class="task-title-sp"></span>
              <span class="badge badge-sm label-success created_at"></span>
              <span class="badge badge-sm task-status"></span>
              <div class="pull-right">

                  {{-- Edit Task Btn --}}
                  <span data-toggle="tooltip" title="Edit Task">
                    <button class="btn btn-primary btn-sm edit-task-btn"
                      data-toggle='modal'
                      data-task-id=""
                      data-task-name=""
                      data-task-desc=""
                      data-target='#editTaskModal'>
                      <i class="fa fa-pencil"></i>
                    </button>
                  </span>
                  <span data-toggle='tooltip' title="Delete this task">

                    <button class="btn btn-danger btn-sm"
                      data-toggle='modal'
                      data-target='#deleteTaskModal'>
                      <i class="fa fa-trash-o "></i>
                    </button>
                    <form method="POST" action="{{route('tasks.destroy', 0)}}" class="hidden">
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}
                      <input type="hidden" name="list" value="{{$list->id}}">
                    </form>
                    
                  </span>
              </div>
          </div>
          <div class="task-body text-muted hidden"></div>
      </li>


@endsection