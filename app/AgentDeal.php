<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agents_id
 * @property string $image
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property Agent $agent
 */
class AgentDeal extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['agents_id', 'image', 'description', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }
    public function airline()
    {
        return $this->belongsTo('App\Airlines', 'airline_id');
    }
}
