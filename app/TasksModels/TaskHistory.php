<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    public function status()
    {
        return $this->belongsTo('App\TasksModels\Status', 'statuses_id');
    }

    public function admin()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }
}
