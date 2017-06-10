
    <div class="col-lg-3 col-md-6">
    <div class="panel panel-green">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-tasks fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge">{{ isset($taskStats[\App\Models\Task::COMPLETED]) ? $taskStats[\App\Models\Task::COMPLETED] : 0}}</div>
                    <div>Completed Tasks!</div>
                </div>
            </div>
        </div>
        <a href="{{route('dashboard.tasks', ['status' => \App\Models\Task::COMPLETED])}}">
            <div class="panel-footer">
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ isset($taskStats[\App\Models\Task::IN_PROGRESS]) ? $taskStats[\App\Models\Task::IN_PROGRESS] : 0}}</div>
                        <div>Tasks In Progress</div>
                    </div>
                </div>
            </div>
        <a href="{{route('dashboard.tasks', ['status' => \App\Models\Task::IN_PROGRESS])}}">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>        

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ isset($taskStats[\App\Models\Task::NOT_STARTED]) ? $taskStats[\App\Models\Task::NOT_STARTED] : 0}}</div>
                        <div>Tasks you didnt start</div>
                    </div>
                </div>
            </div>
        <a href="{{route('dashboard.tasks', ['status' => \App\Models\Task::NOT_STARTED])}}">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>      


    <div class="col-lg-3 col-md-6">
        <div class="panel panel-black">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ isset($taskStats[\App\Models\Task::CANCELED]) ? $taskStats[\App\Models\Task::CANCELED] : 0}}</div>
                        <div>Canceled tasks</div>
                    </div>
                </div>
            </div>
        <a href="{{route('dashboard.tasks', ['status' => \App\Models\Task::CANCELED])}}">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>