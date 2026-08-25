<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $active
 * @property string $created_at
 * @property string $updated_at
 * @property Agent[] $agents
 */
class AgentCity extends Model
{
    public $table = "agent_cities";

    /**
     * @var array
     */
    protected $fillable = ['name', 'active', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents()
    {
        return $this->hasMany('App\Agents', 'cities_id');
    }
    public function jobs()
    {
        return $this->hasMany('App\AgentJobs', 'agent_cities_id');
    }
    public function foreignJobs()
    {
    	return $this->hasMany("App\ForeignJobs",'agent_cities_id');
    }
     public function country()
    {
    	return $this->belongsTo("App\Country",'countries_id');
    }
}
