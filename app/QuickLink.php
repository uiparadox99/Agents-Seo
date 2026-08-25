<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuickLink extends Model
{
    public $table 		= "quick_links";

    public $timestamps 	= false;

    public function section()
    {
    	return $this->belongsTo("App\Section", "sections_id");
    }

    public function country()
    {
    	return $this->belongsTo("App\Country", "countries_id");
    }

}
