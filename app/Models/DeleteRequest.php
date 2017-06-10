<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteRequest extends Model
{	
	protected $table = 'task_lists_delete_requests';

	protected $fillable = ['user_id', 'list_id'];

	public function user()
	{
	  return $this->belongsTo('App\User');
	}

	public function list()
	{
	  return $this->belongsTo('App\Models\TaskList', 'list_id', 'id');
	}	

	const APPROVE_ACTION = 'approve';
	
	const DECLINE_ACTION = 'decline';

}
