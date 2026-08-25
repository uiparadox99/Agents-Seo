<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketsFilter extends Model
{
	public $table = "tickets_filter_blocks";

 public function airlineRelation()
    {
        return $this->belongsTo('App\Airlines', 'airline');
    }
	
}