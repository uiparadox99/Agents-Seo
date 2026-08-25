<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $agent_type_id
 * @property int $users_id
 * @property int $cities_id
 * @property string $slug
 * @property string $business_name
 * @property string $agent_name
 * @property string $email
 * @property string $phone
 * @property string $facebook
 * @property string $twitter
 * @property string $whatsapp
 * @property string $dsl_license
 * @property string $iata_license
 * @property string $dsl_expairy
 * @property string $iata_expairy
 * @property string $description
 * @property string $logo
 * @property string $cover
 * @property string $website
 * @property string $address
 * @property string $active
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $fax
 * @property string $secondary_phone
 * @property string $mobile
 * @property string $secondary_mobile
 * @property string $is_subscribed
 * @property string $dts_attachment
 * @property string $dts_verified
 * @property string $image_alt
 * @property string $ptcl
 * @property string $recomended_status
 * @property string $youtube
 * @property AgentCity $agentCity
 * @property AgentType $agentType
 * @property User $user
 * @property AgentDeal[] $agentDeals
 * @property AgentGallery[] $agentGalleries
 * @property AgentJob[] $agentJobs
 * @property AgentReview[] $agentReviews
 * @property AgentSubscription[] $agentSubscriptions
 * @property AgentTiming[] $agentTimings
 * @property DtsAttachment[] $dtsAttachments
 * @property Flight[] $flights
 */
class Agents extends Model
{
    /**
     * @var array
     */

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['agent_type_id', 'users_id', 'cities_id', 'slug', 'business_name', 'agent_name', 'email', 'phone', 'facebook', 'twitter', 'whatsapp', 'dsl_license', 'iata_license', 'dsl_expairy', 'iata_expairy', 'description', 'logo', 'cover', 'website', 'address', 'active', 'created_at', 'updated_at', 'deleted_at', 'fax','code', 'secondary_phone', 'mobile', 'secondary_mobile', 'is_subscribed', 'dts_attachment', 'dts_verified', 'image_alt', 'ptcl', 'recomended_status', 'youtube'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo('App\AgentCity', 'cities_id');
    }
  
   public function foreignJobs()
    {
    	return $this->hasMany("App\ForeignJobs",'agents_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agentType()
    {
        return $this->belongsTo('App\AgentType');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentDeals()
    {
        return $this->hasMany('App\AgentDeal', 'agents_id');
    }
     public function packages()
    {
        return $this->hasMany('App\Packages', 'agents_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentGallery()
    {
        return $this->hasMany('App\AgentGallery', 'agents_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentJobs()
    {
        return $this->hasMany('App\AgentJobs', 'agents_id');
    }
    public function visitors()
    {
        return $this->hasMany('App\Visitor', 'agents_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentReviews()
    {
        return $this->hasMany('App\AgentReview', 'agents_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentSubscriptions()
    {
        return $this->hasMany('App\AgentSubscription', 'agents_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentTimings()
    {
        return $this->hasMany('App\AgentTiming', 'agents_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dtsAttachments()
    {
        return $this->hasMany('App\DtsAttachment', 'agents_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function flights()
    {
        return $this->hasMany('App\Flight', 'agents_id');
    }
     public function tickets()
    {
        return $this->hasMany('App\SastiTickets', 'agents_id');
    }
    public function hotels()
    {
        return $this->hasMany('App\UmrahHotels', 'agents_id');
    }
}
