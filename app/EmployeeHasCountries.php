<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $booking_id
 * @property int $services_id
 * @property string $start_time
 * @property string $end_time
 * @property string $date
 * @property Booking $booking
 * @property Service $service
 */
class EmployeeHasCountries extends Model
{

    public $timestamps = false;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'admins_has_countries';

    /**
     * @var array
     */
    protected $fillable = ['countries_id', 'admins_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Admin');
    }
}
