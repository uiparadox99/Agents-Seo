<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $active
 * @property string $created_at
 * @property string $updated_at
 * @property AgentJob[] $agentJobs
 */
class JobExperience extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'job_experience';

    /**
     * @var array
     */
    protected $fillable = ['name', 'active', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentJobs()
    {
        return $this->hasMany('App\AgentJobs');
    }
}
