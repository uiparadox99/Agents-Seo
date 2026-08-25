<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Embassy extends Model
{
    public $table 		= "embassy_pages";

    public function country()
	{
		return $this->belongsTo('App\Country', 'countries_id');
	}
	 public function city()
	{
		return $this->belongsTo('App\Cities', 'cities_id');
	}
  
}
