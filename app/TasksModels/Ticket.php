<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function admin()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }

    public function flight()
    {
        return $this->belongsTo('App\TasksModels\Flight', 'flights_id');
    }

    public function trans()
    {
        return $this->belongsTo('App\TasksModels\Transaction', 'id', 'tickets_id');
    }

    public function party()
    {
        return $this->belongsTo('App\TasksModels\Vendee', 'parties_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\TasksModels\Vendee', 'suppliers_id', 'id');
    }

    public function setReportDateAttribute($value) {
        $this->attributes['report_date'] = date('Y-m-d', strtotime($value));
    }
}
