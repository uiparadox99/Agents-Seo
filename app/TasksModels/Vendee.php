<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class Vendee extends Model
{
    public $timestamps = false;
    public function passengers()
    {
    	return $this->hasMany('App\TasksModels\PartyPassengers', 'vendees_id');
    }
    public function admin()
	{
		return $this->belongsTo('App\Agents', 'agents_id');
	}
}
