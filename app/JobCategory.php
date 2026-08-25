<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $active
 * @property string $created_at
 * @property string $updated_at
 * @property string $image
 * @property AgentJob[] $agentJobs
 */
class JobCategory extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'job_category';

    /**
     * @var array
     */
    protected $fillable = ['name', 'active', 'created_at', 'updated_at', 'image'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentJobs()
    {
        return $this->hasMany('App\AgentJob');
    }
    public function designations()
    {
        return $this->hasMany('App\JobDesignation','job_category_id');
    }
    public function allJobs()
    {
        return $this->hasManyThrough(
            AgentJobs::class,       // Final model
            JobDesignation::class, // Intermediate
            'job_category_id',     // Foreign key on JobDesignation
            'job_designations_id', // Foreign key on AgentJob
            'id',                  // Local key on JobCategory
            'id'                   // Local key on JobDesignation
        );
    }
}
