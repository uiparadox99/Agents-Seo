<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HajjPackages extends Model
{
	public $table = "hajj_packages";

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
	

}
