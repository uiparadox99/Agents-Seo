<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airlines extends Model
{
	public $table = "airlines";

	protected $fillable = [
		'countries_id', 
		'name',
		'slug',
		'img',
		'content',
	];
	public function countries()
	{
		return $this->belongsTo('App\Country', 'countries_id');
	}
	public function user()
	{
		return $this->belongsTo('App\User', 'users_id');
	}
	 public function fares()
    {
    	$this->hasMany("App\Fares");
    }
    public function agentJobs()
    {
    	return $this->hasMany("App\AgentJobs",'users_id','users_id');
    }
    public function packagePrice()
	{
		return $this->hasMany('App\PackagePrice');
	}
}
