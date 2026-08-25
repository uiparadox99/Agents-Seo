<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agents_id
 * @property string $day
 * @property string $opening
 * @property string $closing
 * @property string $created_at
 * @property string $updated_at
 * @property Agent $agent
 */
class AgentTiming extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['agents_id', 'day', 'opening', 'closing', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Agent', 'agents_id');
    }
}
