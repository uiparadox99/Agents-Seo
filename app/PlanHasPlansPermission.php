<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $plan_id
 * @property int $plans_permissions_id
 * @property Plan $plan
 * @property PlansPermission $plansPermission
 */
class PlanHasPlansPermission extends Model
{
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plansPermission()
    {
        return $this->belongsTo('App\PlansPermission', 'plans_permissions_id');
    }
}
