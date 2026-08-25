<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $agents_id
 * @property string $expire
 * @property string $created_at
 * @property string $updated_at
 */
class ShowPackage extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'show_package';

    /**
     * @var array
     */
    protected $fillable = ['agents_id', 'expire', 'created_at', 'updated_at'];

}
