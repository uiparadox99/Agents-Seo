<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agents_id
 * @property string $file
 * @property string $active
 * @property string $create_at
 * @property string $updated_at
 * @property Agent $agent
 */
class DtsAttachment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['agents_id', 'file', 'active', 'create_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Agent', 'agents_id');
    }
}
