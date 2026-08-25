<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public $table 		= "sections";

    protected $fillable = [
		'title', 
		'open',
	];

    public $timestamps 	= false;
}
