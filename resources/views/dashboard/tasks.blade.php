@extends('layouts.public')

@section('content')

<div class="row">
@if(isset($statusTxt) && !is_null($statusTxt))
<h2>{{$statusTxt}} Tasks</div>
@endif

<div class="panel panel-default">
  <div class="panel-heading"></div>
  <div class="panel-body">
      <div class="task-content mt20">

          <ul class="task-list p0 m0">
            @if(isset($tasks) && count($tasks))
            @foreach($tasks as $task)
              <li class="">
                  <div class="task-title">
                      <span class="task-title-sp">{{$task->name}}</span>
                      <span class="badge badge-sm ">{{date('d M H:i:s Y', strtotime($task->created_at))}}</span>
                      <span class="badge badge-sm status-{{$task->status}}">{{$task->getStatus()}}</span>

                      <div class="pull-right ">
                          <a href="{{route('lists.show', ['id' => $task->list_id])}}" class="btn btn-success btn-sm"><i class=" fa fa-eye"></i> View task list</a>
                      </div>
                  </div>
                  @if($task->desc != null)
                    <div class="task-body text-muted">{{$task->desc}}</div>
                  @endif
              </li>
            @endforeach
            @else

            <p class="alert alert-info">
              You dont have any tasks 
            </p>
            @endif
 
              
          </ul>
      </div>

      <div class=" add-task-row">
          {{-- <a class="btn btn-success btn-sm pull-left" href="#">Add New Tasks</a> --}}
          {{-- <a class="btn btn-default btn-sm pull-right" href="#">See All Tasks</a> --}}
      </div>
  </div>
</div>

</div>
@endsection
