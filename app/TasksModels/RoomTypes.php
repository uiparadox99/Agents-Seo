<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $active
 * @property string $created_at
 * @property string $updated_at
 * @property HotelSale[] $hotelSales
 */
class RoomTypes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'active', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hotelSales()
    {
        return $this->hasMany('App\TasksModels\HotelSale', 'room_types_id');
    }
}
