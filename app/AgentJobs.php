<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agents_id
 * @property int $agent_cities_id
 * @property int $job_category_id
 * @property string $title
 * @property string $offer
 * @property string $requirement
 * @property string $apply_date
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 * @property string $slug
 * @property AgentCity $agentCity
 * @property Agent $agent
 * @property JobCategory $jobCategory
 * @property JobApplicant[] $jobApplicants
 */
class AgentJobs extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['agents_id', 'agent_cities_id', 'job_category_id', 'title', 'offer', 'requirement', 'apply_date', 'image', 'created_at', 'updated_at', 'slug'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agentCity()
    {
        return $this->belongsTo('App\AgentCity', 'agent_cities_id');
    }

    public function airlineCity()
    {
        return $this->belongsTo('App\Cities', 'agent_cities_id');
    }
    
    public function country()
    {
        return $this->belongsTo('App\Country', 'countries_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobCategory()
    {
        return $this->belongsTo('App\JobCategory');
    }
     public function jobDesignation()
    {
        return $this->belongsTo('App\JobDesignation','job_designations_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobApplicants()
    {
        return $this->hasMany('App\JobApplicant', 'agent_jobs_id');
    }
    public function jobExperience()
    {
        return $this->belongsTo('App\JobExperience');
    }
}
