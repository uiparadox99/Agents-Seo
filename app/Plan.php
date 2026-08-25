<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $active
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 * @property AgentSubscription[] $agentSubscriptions
 * @property PlansPermission[] $plansPermissions
 * @property PlansPriceDiscount[] $plansPriceDiscounts
 */
class Plan extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'plan';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'active', 'type', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agentSubscriptions()
    {
        return $this->hasMany('App\AgentSubscription');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function plansPermissions()
    {
        return $this->belongsToMany('App\PlansPermission', 'plan_has_plans_permissions', null, 'plans_permissions_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plansPriceDiscounts()
    {
        return $this->hasMany('App\PlansPriceDiscount');
    }
}
