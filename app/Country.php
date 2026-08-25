<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Country extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public $table = "countries";

    public function visas()
    {
    	return $this->hasMany("App\Visa");
    }
    public function cities()
    {
    	return $this->hasMany("App\Cities");
    }
    public function agentCities()
    {
    	return $this->hasMany("App\AgentCity",'countries_id');
    }
    public function foreign_jobs()
    {
    	return $this->hasMany("App\ForeignJobs",'countries_id');
    }
    public function airline()
    {
        return $this->hasMany("App\Airlines");
    }
    public function embassy()
    {
        return $this->hasMany("App\Embassy");
    }
      public function employee()
    {
        return $this->hasMany('App\Employee');
    }
    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }
}
