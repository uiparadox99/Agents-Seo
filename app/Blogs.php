<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
	public $table = "blogs";

	protected $casts = [
		'is_featured' => 'integer',
	];

	public function blogsCategory()
	{
		return $this->belongsTo('App\BlogsCategory', 'blog_category_id');
	}

	/**
	 * Get web-accessible image URL with reliable fallback
	 */
	public function getImageUrlAttribute()
	{
		if (!empty($this->image)) {
			if (file_exists(public_path('storage/uploads/blogs/' . $this->image))) {
				return asset('storage/uploads/blogs/' . $this->image);
			}
			if (file_exists(base_path('storage/uploads/blogs/' . $this->image))) {
				return asset('storage/uploads/blogs/' . $this->image);
			}
			if (file_exists(storage_path('app/public/uploads/blogs/' . $this->image))) {
				return asset('storage/uploads/blogs/' . $this->image);
			}
			if (file_exists(public_path('uploads/blogs/' . $this->image))) {
				return asset('uploads/blogs/' . $this->image);
			}
			return asset('storage/uploads/blogs/' . $this->image);
		}
		return asset('images/blog-default.jpg');
	}
}
