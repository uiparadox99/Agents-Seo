<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $distance_id
 * @property string $address
 * @property string $city
 * @property string $phone
 * @property string $status
 * @property string $hotel_type
 * @property int $hotel_category
 * @property string $hotel_facilities
 * @property string $created_at
 * @property string $updated_at
 * @property UmrahHotel[] $umrahHotels
 */
class Hotels extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'distance_id', 'address', 'city', 'phone', 'status', 'hotel_type', 'hotel_category', 'hotel_facilities', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function umrahHotels()
    {
        return $this->hasMany('App\UmrahHotels', 'hotels_id');
    }
    public function category()
    {
        return $this->belongsTo(HotelCategory::class, 'hotel_category');
    }
    
    public function distance()
    {
        return $this->belongsTo(HotelDistance::class, 'distance_id');
    }
    public function cityName()
    {
        return $this->belongsTo(Cities::class, 'city', 'id');
    }
}
