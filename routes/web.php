<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# 
# 
# Guest & Logged Users Routes
# 
# 

Route::get('/', 'IndexController@index')->name('index');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/dashboard/tasks', 'DashboardController@showTasks')->name('dashboard.tasks');

Route::resource('lists', 'TaskListsController', ['except' => ['create', 'edit']]);

Route::post('/lists/deleteRequest', 'TaskListsController@makeDeleteRequest')->name('lists.deleteRequest');

Route::post('/lists/archive', 'TaskListsController@archiveList')->name('lists.archive');

Route::get('/dashnoard/export-tasks', 'DashboardController@exportTasks')->name('dashboard.export');

Route::resource('tasks', 'TasksController');


# 
# 
# Admin Routes
# 
# 

Route::group(['middleware' => 'admin', 'namespace'=> 'admin'], function(){

	Route::get('/admin', 'DashboardController@index')->name('admin.dashboard');
	Route::get('/admin/users', 'DashboardController@users')->name('admin.users');	

	Route::post('/admin/users/assign-role/{role}', 'DashboardController@addUserRole')->name('admin.users.assignRole');
	Route::get('/admin/delete-requests', 'DashboardController@deleteRequestsList')->name('admin.deleteRequests.show');	
	Route::post('/admin/delete-requests/{action}', 'DashboardController@processDeleteRequest')->name('admin.deleteRequests.process');	

});