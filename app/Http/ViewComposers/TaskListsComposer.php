<?php 

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class TaskListsComposer {

    /**
     * If user is logged in, fetch the his latest
     * tasks list and bind them to view
     * Bind current Route name to view
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $route = Route::getCurrentRoute();
        $routeName = $route->getName();

        if (!Auth::guest()) {

            $view->with('taskLists', TaskList::select('id', 'name')->where('user_id', Auth::user()->id)
                ->limit(15)
                ->orderBy('id', 'desc')
                ->get()
            );

            # Some task statistics for the dashboard
            if($routeName == 'dashboard') {
                $stats = DB::table('tasks')
                    ->select(['status', DB::raw('COUNT(*) as count')])
                    ->groupBy('status')
                    ->where('user_id', Auth::user()->id)
                    ->get();

                $viewStats = [];

                foreach ($stats as $key => $stat) {
                    $viewStats[$stat->status] = $stat->count;    
                }

                $view->with('taskStats', $viewStats);

            }
        }


        $view->with('activeList', $route->parameter('list', false));

        $view->with('activeRoute', $routeName);
    }


}