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
class JobDesignation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'job_designations';

    /**
     * @var array
     */
    protected $fillable = ['name', 'active', 'created_at', 'updated_at', 'image'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentJobs()
    {
        return $this->hasMany('App\AgentJobs','job_designations_id');
    }
    public function category()
    {
        return $this->belongsTo('App\JobCategory','job_category_id');
    }
}
