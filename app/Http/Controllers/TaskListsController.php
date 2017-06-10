<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskList;

use App\Models\DeleteRequest;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TaskListsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        return redirect()->route('dashboard');
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
            $response = ['error' => 0, 'success' => 0, 'msg' => 'List created'];

            $input = $this->sanitize($request->all());
            
            if (!isset($input['name']) || !$input['name']) {

                throw new AppException(sprintf(config('view.messages.form_param_required'), 'List Name'));
            }
            
            $list = new TaskList([
                'name' => $input['name'],
                'user_id' => Auth::user()->id
            ]);

            $list->save();

            $response['success'] = 1;

            $response['redirectUrl'] = route('lists.show', ['id' => $list->id]);

        } catch (AppException $e) {
            
            $response['error'] = 1;

            $response['msg'] = $e->getMessage();

        } catch (Exception $e) {

            Log::error($e);

            $response['error'] = 1;

            $response['msg'] = 'Error, try again later';            
        }

        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModelsTaskList  $listModel
     * @return \Illuminate\Http\Response
     */
    public function show(TaskList $listModel, $id)
    {
        try {

            $view = view('lists.view');

            if ($id < 1) {

                throw new AppException("Wrong Parameters supplied", 1);
            }

            $record = $listModel::where('id', $id)
                ->with(['tasks', 'deleteRequest'])
                ->first();

            if (!$record || $record->user_id != Auth::user()->id) {

                throw new AppException(config('view.messages.list_not_found'), 1);
            }

            $view->list = $record;

        } catch (AppException $e) {

            return redirect()->route('dashboard')->with('warning', $e->getMessage());

        } catch (Exception $e) {

            Log::error($e);

            return redirect()->route('dashboard')->with('error', config('view.messages.system_error'));            
        }


        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskList  $listModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            $id = $request->input('id', false);

            if (!$id) {
                throw new AppException(config('view.messages.list_not_found'));
            }

            $listModel = TaskList::find($id);            

            if (!$listModel || $listModel->user_id != Auth::user()->id) {

                throw new AppException(config('view.messages.list_not_found'));
            }

            $input = $this->sanitize($request->all());
            
            if (!isset($input['name']) || !$input['name']) {

                throw new AppException(sprintf(config('view.messages.form_param_required'), 'List Name'));
            }
            
            $listModel->name = $input['name'];

            $listModel->save();

            Session::flash('success', sprintf(config('view.messages.list_success'), 'edited'));

        } catch (AppException $e) {

            Session::flash('danger', $e->getMessage());

        } catch (Exception $e) {

            \Log::error($e);

            Session::flash('danger', config('view.messages.system_error'));
        }
        if (isset($listModel) && !empty($listModel)) {
            return redirect()->route('lists.show', $listModel->id);
        } else {
            return redirect()->route('dashboard');            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $input = $request->all();

        try {


            if (!isset($input['id'])) {
                throw new AppException(config('view.messages.list_not_found'));
            }
            
            $list = TaskList::where('id', $input['id'])->first();
            
            if (!$list) {
                throw new AppException(config('view.messages.list_not_found'));
            }

            DB::table('tasks')->where('list_id', $list->id)->delete();

            $list->delete();

            Session::flash('success', sprintf(config('view.messages.action_success'), 'Task List', 'deleted'));

        } catch (AppException $e) {

            Session::flash('danger', $e->getMessage());

        } catch (Exception $e) {

            Log::error($e);

            Session::flash('danger', config('view.messages.system_error'));
        }

        return redirect()->route('dashboard');


    }

    public function makeDeleteRequest(Request $request) 
    {
        try {

            $listId = $request->input('id', false);

            if (!$listId) {
                throw new AppException(config('view.messages.list_not_found'));
            }

            $list = TaskList::find($listId);

            if (!$list)
                throw new AppException(sprintf(config('view.messages.not_found'), 'List', $listId));

            if ($list->delete_available == 1) {
                throw new AppException(config('view.messages.delete_available'), 1);
            }

            $deleteRequest = new DeleteRequest([
                'list_id' => $list->id,
                'user_id' => Auth::user()->id,
            ]);

            $deleteRequest->save();

            Session::flash('success', config('view.delete_request_made'));

        } catch (AppException $e) {

            Session::flash('danger', $e->getMessage());

        } catch (Exception $e) {

            Log::error($e);

            Session::flash('danger', config('view.messages.system_error'));
        }

        if (isset($list) && !empty($list)) {
            return redirect()->route('lists.show', $list->id);
        } else {
            return redirect()->route('dashboard');            
        }
    }    

    public function archiveList(Request $request) {
        try {

            $listId = $request->input('id', false);

            if (!$listId) {
                throw new AppException(config('view.messages.list_not_found'));
            }

            $list = TaskList::where('id', $listId)->with('tasks')->first();

            if (!$list)
                throw new AppException(sprintf(config('view.messages.not_found'), 'List', $listId));

            if (count($list->tasks) < 1)
                throw new AppException(config('view.messages.archive_no_tasks'), 1);

            $list->is_archived = 1;

            $list->save();
            
            Session::flash('success', sprintf(config('view.messages.action_success'), 'Task List', 'archived'));    
            
        } catch (AppException $e) {

            Session::flash('danger', $e->getMessage());

        } catch (Exception $e) {

            Log::error($e);

            Session::flash('danger', config('view.messages.system_error'));
        }

        if (isset($list) && !empty($list)) {
            return redirect()->route('lists.show', $list->id);
        } else {
            return redirect()->route('dashboard');            
        }        
    }
}
