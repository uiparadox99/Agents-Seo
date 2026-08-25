<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agents_id
 * @property string $hotel_name
 * @property string $city
 * @property string $hotel_star
 * @property string $agent_name
 * @property string $rate
 * @property string $room_type
 * @property string $meal_type
 * @property string $price_start
 * @property string $price_end
 * @property string $create_at
 * @property string $updated_at
 * @property Agent $agent
 */
class UmrahHotels extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['agents_id', 'hotel_name', 'city', 'hotel_star', 'agent_name', 'rate', 'room_type', 'meal_type', 'price_start', 'price_end', 'create_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }
     public function hotel()
    {
        return $this->belongsTo('App\Hotels', 'hotels_id');
    }
}
