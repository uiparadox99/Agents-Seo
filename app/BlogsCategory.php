<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogsCategory extends Model
{
	public $table = "blog_category";

	public function blogs()
	{
		$this->hasMany("App\blogs");
	}
	
}
