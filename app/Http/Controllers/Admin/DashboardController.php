<?php 

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Controller as AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Role;
use App\Models\DeleteRequest;

use App\Exceptions\AppException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class DashboardController extends AdminController {

	/**
	 * beautiful dashboard
	 * @param Request $request [description]
	 * @param [type]  $role    [description]
	 */
	public function index(Request $request) {

		return view('admin.dashboard.index');
	}

	/**
	 * Show registered users
	 * @param Request $request [description]
	 * @param [type]  $role    [description]
	 */
	public function users(Request $request) {
		$users = User::orderBy('id', 'desc')->with('roles')->simplePaginate(8);

		return view('admin.dashboard.users', ['users' => $users]);
	}	

	/**
	 * Assign role to user
	 * @param Request $request [description]
	 * @param [type]  $role    [description]
	 */
	public function addUserRole(Request $request, $role) {
		try {
			$input = $this->sanitize($request->all());

			if (!isset($input['user_id'])) {
				throw new AppException(sprintf(config('view.messages.param_required'), 'User Id'), 1);
			}

			$user = User::find($input['user_id']);

			if (!$user) {
				throw new AppException(sprintf(config('view.messages.not_found'), 'User', $input['user_id']), 1);
			}

			if (!$role) {
				throw new AppException(sprintf(config('view.messages.param_required'), 'Role'), 1);
			}

			$roleModel = Role::where('name', $role)->first();

			if (!$roleModel) {
				throw new AppException(sprintf(config('view.messages.not_found'), 'Role', $role), 1);
			}

    		$user->roles()->attach($roleModel);    	

			Session::flash('success', sprintf(config('view.messages.role_assigned'), $roleModel->name, $user->name));

		} catch (AppException $e) {

			Session::flash('warning', $e->getMessage());

		} catch (Exception $e) {

            Session::flash('danger', config('view.messages.system_error'));

            Log::error($e);		
        }

        return redirect()->route('admin.users', ['page' => isset($input['page']) ? $input['page'] : 1]);

	}

	/**
	 * List with the delete requests
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function deleteRequestsList(Request $request) {
		
		$requests = DeleteRequest::orderBy('id', 'asc')->with(['user','list'])->simplePaginate(10);

		return view('admin.dashboard.delete-requests', ['requests' => $requests]);
	}	

	public function processDeleteRequest(Request $request, $action) {
		try {
			$input = $request->all();

			if (!isset($input['request_id'])) {
				throw new AppException(sprintf(config('view.messages.param_required'), 'Request Id'), 1);
			}

			if (!isset($action) || $action != DeleteRequest::APPROVE_ACTION 
				&& $action != DeleteRequest::DECLINE_ACTION ) {
				throw new AppException(sprintf(config('view.messages.not_found'), 'Action', $action));
			}


			$requestRecord = DeleteRequest::where('id', $input['request_id'])->with('list')->first();

			if (!$requestRecord) {
				throw new AppException(sprintf(config('view.messages.not_found'), 'DeleteRequest', $input['request_id']));				
			}

			if ($action == DeleteRequest::APPROVE_ACTION) {

				$requestRecord->list->delete_available = 1;

				$requestRecord->list->save();

				$requestRecord->delete();
				Session::flash('success', sprintf(config('view.messages.action_success'), 'DeleteRequest', 'approved'));

			} else {
				$requestRecord->delete();
				Session::flash('success', sprintf(config('view.messages.action_success'), 'DeleteRequest', 'declined'));
			}


		} catch (AppException $e) {

			Session::flash('warning', $e->getMessage());

		} catch (Exception $e) {

            Session::flash('danger', config('view.messages.system_error'));

            Log::error($e);		
        }

        return redirect()->route('admin.users', ['page' => isset($input['page']) ? $input['page'] : 1]);

	}	
}