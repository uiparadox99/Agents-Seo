<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agents_id
 * @property int $plan_id
 * @property string $name
 * @property string $description
 * @property string $active
 * @property string $facilities
 * @property string $start_date
 * @property string $end_date
 * @property string $created_at
 * @property string $updated_at
 * @property Agent $agent
 * @property Plan $plan
 */
class AgentSubscription extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['agents_id', 'plan_id', 'period', 'expairy_date', 'active', 'facilities', 'start_date', 'end_date', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }
}
