<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    //
       public function agent()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }


}
