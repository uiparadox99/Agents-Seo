<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagePrice extends Model
{
	public $table = "packages_price";

	protected $fillable = [
		'price',
		'stars',
		'airlines_id',
		'section',
		'nights',
	];
	public function Package()
	{
		return $this->belongsTo('App\Packages', 'packages_price_id');
	}
	public function airlines()
	{
		return $this->belongsTo('App\Airlines', 'airlines_id');
	}

}
