<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agent_jobs_id
 * @property string $name
 * @property string $number
 * @property string $attachment
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property string $remarks
 * @property AgentJob $agentJob
 * @property JobAttachement[] $jobAttachements
 */
class JobApplicant extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'job_applicant';

    /**
     * @var array
     */
    protected $fillable = ['agent_jobs_id', 'name', 'number', 'attachment', 'email', 'created_at', 'updated_at', 'remarks'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agentJob()
    {
        return $this->belongsTo('App\AgentJobs', 'agent_jobs_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobAttachements()
    {
        return $this->hasMany('App\JobAttachment');
    }
}
