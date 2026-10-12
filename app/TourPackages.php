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

    public function productReviews()
    {
        return $this->hasMany('App\ProductReview', 'product_id')->where('product_type', 'tour');
    }

    public function approvedProductReviews()
    {
        return $this->productReviews()->where('approved', 1);
    }

    public function getStartingPriceAttribute()
    {
        if (!empty($this->price)) {
            $num = (float) str_replace(',', '', (string) $this->price);
            if ($num > 0) {
                return $num;
            }
        }
        return null;
    }
}
