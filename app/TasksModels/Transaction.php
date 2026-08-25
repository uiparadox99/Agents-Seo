<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
        protected $table = 'transactions_tasks';
	public function setTransDateAttribute($value)
	{
		$this->attributes['trans_date'] = date('Y-m-d', strtotime($value));
	}

	public function getCreatedAtAttribute($value)
	{
		return date('d-M-Y', strtotime($value));
	}

	public function getTransDateAttribute($value)
	{
		return date('d-M-Y', strtotime($value));
	}

    public function setReportDateAttribute($value) {
        $this->attributes['trans_date'] = date('Y-m-d', strtotime($value));
    }

    public function ticket()
    {
        return $this->belongsTo('App\TasksModels\Ticket', 'tickets_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\TasksModels\Vendee',  'from', 'id');
    }

    public function party()
    {
        return $this->belongsTo('App\TasksModels\Vendee', 'to', 'id');
    }


    public function admin()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }

}
