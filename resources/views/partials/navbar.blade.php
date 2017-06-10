<div class="nav-side-menu">
<div class="brand">Task Manager</div>
<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
<div class="menu-list">
    <ul id="menu-content" class="menu-content collapse out">
        @if (Auth::guest())
        <li class="{{ $activeRoute == 'index' ? 'active' : '' }}">
            <a href="{{ route('index') }}"> 
                <i class="fa fa-home fa-lg"></i> About
            </a>
        </li>

        <li class="{{ $activeRoute == 'login' ? 'active' : '' }}">
            <a href="{{ route('login') }}"> 
                <i class="fa fa-key fa-lg"></i> Login
            </a>
        </li>

        <li class="{{ $activeRoute == 'register' ? 'active' : '' }}">
            <a href="{{ route('register') }}"> 
                <i class="fa fa-user-circle fa-lg"></i> Register
            </a>
        </li>

        @else
        
        <li data-toggle="collapse" data-target="#userProfile" class="collapsed">
            <a href="#" title="">
                <i class="fa fa-user fa-lg"></i> 
                {{ Auth::user()->name }} 
                <span class="arrow"></span>
            </a>
        </li>

        <ul class="sub-menu collapse" id="userProfile">
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off fa-lg"></i> Logout
                </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>                            
            </li>
            @if(Auth::user()->hasRole('admin'))
            <li>
                <a href="{{route('admin.dashboard')}}"><i class="fa fa-user fa-lg"></i> Admin </a>
            </li>
            @endif
        </ul>

        <li class="{{ $activeRoute == 'dashboard' ? 'active' : '' }}">
            <a href="{{route('dashboard')}}">
                <i class="fa fa-dashboard fa-lg"></i> Dashboard
            </a>
        </li>
                    

        @endif   
        
        {{-- Print User's task lists if any --}}
        @if(isset($taskLists) && count($taskLists))

            <li data-toggle="collapse" 
                data-target="#taskLists" 
                class="{{ $activeRoute == 'lists.show' ? 'active' : '' }}"
                aria-expanded="true">
                <a href="#">
                    <i class="fa fa-tasks fa-lg"></i>
                    Task Lists Available
                    <span class="label label-primary pull-right mr10 mt10">
                        {{count($taskLists)}}
                    </span>
                </a>
            </li>

            <ul  class="sub-menu collapse in" aria-expanded="true" id="taskLists">

            @foreach($taskLists as $list)
                <li class="{{ ($activeRoute == 'lists.show' && $activeList == $list->id) ? 'active' : '' }}">
                    <a href="{{route('lists.show', $list->id)}}" title="{{$list->name}}">
                     <i class="fa fa-paperclip fa-lg"></i>{{$list->name}}
                    </a>
                </li>
            @endforeach

            </ul>

        @endif


    </ul>

    {{-- News Task List Btn --}}
    <div class="text-center mt10 hidden-xs">
    @if(Auth::guest())

        <button class="btn btn-success btn-sm" 
            data-toggle="modal" 
            data-target="#loginModal">     
            <i class="fa fa-plus"></i> Create New Task List
        </button>
    @else
        <button class="btn btn-success btn-sm" 
            data-toggle="modal" 
            data-target="#addTaskListModal">     
            <i class="fa fa-plus"></i> Create New Task List
        </button>
    @endif
    </div>


</div>
</div>