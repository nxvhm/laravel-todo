<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected  $table = 'tasks';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'desc', 
        'status',
        'user_id',
        'list_id',
    ];

    # Available Task Statuses
    const COMPLETED = 'completed';

    const IN_PROGRESS = 'in_progress';

    const CANCELED = 'canceled';

    const NOT_STARTED = 'not_started';

    public function list()
    {
        return $this->hasOne('App\Models\TaskList', 'id', 'list_id');
    }

    /**
     * get Readable status
     * @return string [description]
     */
    public function getStatus() {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    /**
     * [getStatusesArray description]
     * @return array [description]
     */
    public static function getStatusesArray() {
        return [
            self::COMPLETED,
            self::IN_PROGRESS,
            self::CANCELED,
            self::NOT_STARTED
        ];
    }
}
