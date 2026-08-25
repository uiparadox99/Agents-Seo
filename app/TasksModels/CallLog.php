<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    public function admin()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }

    public function party()
    {
        return $this->belongsTo('App\TasksModels\Vendee', 'vendees_id');
    }

    public function flight()
    {
        return $this->belongsTo('App\TasksModels\Flight', 'flights_id');
    }

    public function attachment()
    {
        return $this->hasMany('App\TasksModels\TaskAttachment', 'vendees_id', 'vendees_id');
    }

    public function setTravelDateAttribute($value) {
        $this->attributes['travel_date'] = date('Y-m-d', strtotime($value));
    }

    public function setCallDateTimeAttribute($value) {
        $this->attributes['call_date_time'] = date('Y-m-d H:i:s', strtotime($value));
    }
}
