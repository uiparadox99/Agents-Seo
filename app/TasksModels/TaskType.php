<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    public function tasks()
    {
        return $this->hasMany('App\TasksModels\Task', 'task_types_id');
    }
}
