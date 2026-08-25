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
class TourPackages extends Model
{
    /**
     * @var array
     */
    
protected $table = 'tour_packages';
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
 

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }
    public function pricings()
    {
        return $this->hasMany('App\TourPackagesPrices', 'tour_packages_id');
    }

 

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    
}
