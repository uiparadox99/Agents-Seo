<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $active
 * @property string $created_at
 * @property string $updated_at
 * @property Plan[] $plans
 */
class PlansPermission extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'active', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function plans()
    {
        return $this->belongsToMany('App\Plan', 'plan_has_plans_permissions', 'plans_permissions_id');
    }
}
