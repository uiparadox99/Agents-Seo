<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agents_id
 * @property string $image
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property Agent $agent
 */
class AgentGallery extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'agent_gallery';

    /**
     * @var array
     */
    protected $fillable = ['agents_id', 'image', 'title', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }
}
