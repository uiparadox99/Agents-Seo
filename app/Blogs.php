<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
	public $table = "blogs";

	public function blogsCategory()
	{
		return $this->belongsTo('App\BlogsCategory', 'blog_category_id');
	}
	
}
