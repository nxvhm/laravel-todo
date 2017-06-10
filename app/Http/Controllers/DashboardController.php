<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use App\Exceptions\AppException;
use Excel;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.index');
    }

    public function showTasks(Request $request) {
        try {

            $status = $request->input('status', null);

            $statuses = Task::getStatusesArray();

            if ($status && !in_array($status, $statuses)) {
                throw new AppException(sprintf(config('view.messages.not_found'), 'Status', $status), 1);
            }

            $query = Task::where('user_id', Auth::user()->id)->orderBy('id','desc');

            $view = view('dashboard.tasks');
            
            if (isset($status) && !is_null($status)) {
                $query->where('status', $status);
                $view->status = $status;
                $view->statusTxt = ucfirst(str_replace('_', ' ', $status));
            }   


            $tasks = $query->simplePaginate(15);

            
            $view->tasks = $tasks;


        } catch (AppException $e) {

            Session::flash('warning', $e->getMessage());

            return redirect()->route('dashboard');

        } catch (Exception $e) {

            Session::flash('danger', config('view.messages.system_error'));

            Log::error($e);

            return redirect()->route('dashboard');

        }

        return $view;
    }

    public function exportTasks() {
        $data = Task::where('user_id', Auth::user()->id)->get()->toArray();

        return Excel::create('task_list', function($excel) use ($data) {

            $excel->sheet('tasks', function($sheet) use ($data)

            {

                $sheet->fromArray($data);

            });

        })->download('xls');

        return redirect()->route('dashboard');
    }

}
