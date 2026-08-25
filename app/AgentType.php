<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $active
 * @property string $created_at
 * @property string $updated_at
 * @property Agent[] $agents
 */
class AgentType extends Model
{
    
    /**
     * The table associated with the model.sasd
     * 
     * @var string
     */
    protected $table = 'agent_type';

    /**
     * @var array
     */
    protected $fillable = ['name','image', 'active', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents()
    {
        return $this->hasMany('App\Agents');
    }

}
