<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $active
 * @property string $created_at
 * @property string $updated_at
 * @property VisaSale[] $visaSales
 */
class VisaTypes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'active', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visaSales()
    {
        return $this->hasMany('App\TasksModels\VisaSale', 'visa_types_id');
    }
}
