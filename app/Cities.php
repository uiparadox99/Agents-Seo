<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
	public $table = "cities";

	protected $fillable = [
		'countries_id', 
		'name',
	];
	public function countries()
	{
		return $this->belongsTo('App\Country', 'countries_id');
	}
	
}
