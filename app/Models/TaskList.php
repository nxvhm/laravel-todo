<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
	protected  $table = 'task_lists';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'delete_available', 'is_archived'
    ];

    public function tasks() {
    	return $this->hasMany('App\Models\Task', 'list_id')->orderBy('id', 'desc');
    }

    public function deleteRequest() {
        return $this->hasOne('App\Models\DeleteRequest', 'list_id', 'id');
    }    
}
