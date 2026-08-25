<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agents_id
 * @property int $users_id
 * @property string $rating
 * @property string $message
 * @property string $created_at
 * @property string $updated_at
 * @property Agent $agent
 * @property User $user
 */
class AgentReview extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['agents_id', 'users_id', 'rating', 'message', 'created_at', 'updated_at'];

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
    public function user()
    {
        return $this->belongsTo('App\User', 'users_id');
    }
}
