<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	 public $timestamps = false;
    public function status()
    {
    	return $this->belongsTo('App\Agents', 'statuses_id');
    }
}
