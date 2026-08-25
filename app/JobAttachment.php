<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $job_applicant_id
 * @property string $attachment
 * @property string $created_at
 * @property string $updated_at
 * @property JobApplicant $jobApplicant
 */
class JobAttachment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['job_applicant_id', 'attachment', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobApplicant()
    {
        return $this->belongsTo('App\JobApplicant');
    }
}
