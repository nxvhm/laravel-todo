<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Task;
use App\Models\TaskList;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\Session;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $response = ['error' => 0, 'success' => 0, 'msg' => 'Task created'];

            $input = $this->sanitize($request->all());

            $requiredParams = ['name', 'status', 'list_id'];

            foreach ($requiredParams as $param) {

                if (!isset($input[$param])) {
                
                    throw new AppException(sprintf(config('view.messages.form_param_required'), $param));
                }
            }

            $list = TaskList::find($input['list_id']);

            if (!$list) {
                throw new AppException(config('view.messages.list_not_found'));
            }
            
                
            $task = new Task([
                'name' => $input['name'],
                'user_id' => Auth::user()->id,
                'list_id' => $list->id,
                'desc' => isset($input['desc']) ? $input['desc'] : null ,
                'status' => $input['status']
            ]);

            $task->save();

            $response['success'] = 1;

            $response['task_id'] = $task->id;
            
            $response['created_at'] = date('d M H:i Y', strtotime($task->created_at));

            $response['statusTxt'] = $task->getStatus();
            
            $response['msg'] = sprintf(config('view.messages.task_success'), 'created');


        } catch (AppException $e) {
            
            $response['error'] = 1;

            $response['msg'] = $e->getMessage();

        } catch (Exception $e) {

            Log::error($e);

            $response['error'] = 1;

            $response['msg'] = config('view.messages.system_error');            
        }

        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        try {
            $list = $request->input('list', false);

            if (!$task) {
                throw new AppException(config('view.messages.task_not_found'), 1);
            }

            $input = $this->sanitize($request->all());


            $requiredParams = ['name', 'status', 'desc'];

            foreach ($requiredParams as $param) {

                if (!isset($input[$param])) {
                
                    throw new AppException(sprintf(config('view.messages.form_param_required'), $param));
                }
            }            

            $task->name = $input['name'];

            $task->desc = $input['desc'];

            $task->status = $input['status'];

            $task->save();

            Session::flash('success', sprintf(config('view.messages.task_success'), 'edited'));
            
        } catch (AppException $e) {

            Session::flash('warning', $e->getMessage());

        } catch (Exception $e) {

            Session::flash('danger', config('view.messages.system_error'));

            Log::error($e);
        }

        if (isset($list)) {
            return redirect()->route('lists.show', $list);
        } else {
            return redirect()->route('dashboard');
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task, Request $request)
    {
        try {
            
            $list = $request->input('list', false);

            if (!$task) {
                throw new AppException(config('view.messages.task_not_found'), 1);
            }

            $task->delete();

            Session::flash('success', 'Task Deleted');
            
        } catch (AppException $e) {

            Session::flash('warning', $e->getMessage());

        } catch (Exception $e) {

            Log::error($e);
            
            Session::flash('danger', config('view.messages.system_error'));            
        }


        if (isset($list)) {
            return redirect()->route('lists.show', $list);
        } else {
            return redirect()->route('dashboard');
        }

    }
}
