<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fares extends Model
{
	public $table = "fares";

	protected $fillable = [
		'airlines_id', 
		'from',
		'to',
		'price',
		'return',
	];
	public function airline()
	{
		return $this->belongsTo('App\Airlines', 'airlines_id');
	}
}
