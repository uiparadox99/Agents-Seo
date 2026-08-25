<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $meter
 * @property string $created_at
 * @property string $updated_at
 */
class HotelDistance extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'distance';

    /**
     * @var array
     */
    protected $fillable = ['name', 'meter', 'created_at', 'updated_at'];

}
