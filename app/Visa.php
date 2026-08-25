<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visa extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	public $table = "visas";

	protected $fillable = [
		'countries_id', 
		'country_name',
		'sites_id',
		'sections_id',
		'title',
		'slug',
		'keywords',
		'is_right',
		'meta_title',
		'meta_desc',
		'tags',
		'content',
		'is_home',
	];
	public function countries()
	{
		return $this->hasMany('App\Country', 'countries_id');
	}
}
