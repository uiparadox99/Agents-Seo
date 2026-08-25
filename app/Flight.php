<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $agents_id
 * @property int $airlines_id
 * @property string $pnr
 * @property int $status
 * @property string $status_date_time
 * @property string $payment_percentage
 * @property string $status_remarks
 * @property string $umrah_block
 * @property string $flight_number
 * @property string $first_from
 * @property string $first_to
 * @property string $return_from
 * @property string $return_to
 * @property string $return_flight_number
 * @property boolean $one_way_or_return
 * @property string $out_bound_date
 * @property string $in_bound_date
 * @property string $one_way_departure_time
 * @property string $one_way_arrival_time
 * @property string $return_departure_time
 * @property string $return_arrival_time
 * @property float $cost_price
 * @property float $child_price
 * @property float $infant_price
 * @property int $seats
 * @property string $available_seats
 * @property string $extra_flight_code1
 * @property string $extra_trancend_date
 * @property string $extra_via
 * @property string $extra_to
 * @property string $extra_r_flight_code1
 * @property string $extra_r_trancend_date
 * @property string $extra_r_via
 * @property string $extra_r_to
 * @property string $extra_one_way_departure_time1
 * @property string $extra_one_way_arrival_time1
 * @property string $extra_return_departure_time1
 * @property string $extra_return_arrival_time1
 * @property string $extra_flight_code2
 * @property string $extra_from_2
 * @property string $extra_to_2
 * @property string $extra_r_flight_code2
 * @property string $extra_r_from_2
 * @property string $extra_r_to_2
 * @property string $extra_one_way_departure_time2
 * @property string $extra_one_way_arrival_time2
 * @property string $extra_return_departure_time2
 * @property string $extra_return_arrival_time2
 * @property string $created_at
 * @property string $premium
 * @property string $updated_at
 * @property Agent $agent
 * @property Airline $airline
 */
class Flight extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['agents_id', 'airlines_id', 'pnr', 'status', 'status_date_time', 'payment_percentage', 'status_remarks', 'umrah_block', 'flight_number', 'first_from', 'first_to', 'return_from', 'return_to', 'return_flight_number', 'one_way_or_return', 'out_bound_date', 'in_bound_date', 'one_way_departure_time', 'one_way_arrival_time', 'return_departure_time', 'return_arrival_time', 'cost_price', 'child_price', 'infant_price', 'seats', 'available_seats', 'extra_flight_code1', 'extra_trancend_date', 'extra_via', 'extra_to', 'extra_r_flight_code1', 'extra_r_trancend_date', 'extra_r_via', 'extra_r_to', 'extra_one_way_departure_time1', 'extra_one_way_arrival_time1', 'extra_return_departure_time1', 'extra_return_arrival_time1', 'extra_flight_code2', 'extra_from_2', 'extra_to_2', 'extra_r_flight_code2', 'extra_r_from_2', 'extra_r_to_2', 'extra_one_way_departure_time2', 'extra_one_way_arrival_time2', 'extra_return_departure_time2', 'extra_return_arrival_time2', 'created_at', 'premium', 'updated_at'];

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
    public function airline()
    {
        return $this->belongsTo('App\Airlines', 'airlines_id');
    }
}
