<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
	public $table = "umrah_packages";

	protected $fillable = [
		'packages_price_id', 
		'name',
		'image',
		'from',
		'to',
		'content1',
		'content2',
		'content3',
		'content4',
		'agents_id',
	];
	public function packagePrice()
	{
		return $this->hasMany('App\PackagePrice');
	}
	 public function agent()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }
     public function airline()
    {
        return $this->belongsTo('App\Airlines', 'airlines_id');
    }
     public function return_airline()
    {
        return $this->belongsTo('App\Airlines', 'return_airlines_id');
    }
     public function makkah_hotel()
    {
        return $this->belongsTo('App\Hotels','hotel_makkah', 'id');
    }
    public function madinah_hotel()
    {
        return $this->belongsTo('App\Hotels','hotel_madinah', 'id');
    }
     public function city()
    {
        return $this->belongsTo('App\Cities', 'hotels.id','hotel_madinah');
    }
	

}
