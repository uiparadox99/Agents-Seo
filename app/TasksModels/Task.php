<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

	public function admin()
	{
		return $this->belongsTo('App\Agents', 'agents_id');
	}

	public function party()
	{
		return $this->belongsTo('App\TasksModels\Vendee', 'vendees_id');
	}

	public function type()
	{
		return $this->belongsTo('App\TasksModels\TaskType', 'task_types_id');
	}

    public function history()
    {
        return $this->hasMany('App\TasksModels\TaskHistory', 'tasks_id');
    }

    public function attachment()
    {
        return $this->hasMany('App\TasksModels\TaskAttachment', 'tasks_id');
    }
}
