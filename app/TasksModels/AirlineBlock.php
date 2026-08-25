<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class AirlineBlock extends Model
{
    public $table = "airlineseatsblockingdetails";

    protected $fillable =  [
        "agents_id",
        "airlines_id",
        "pnr",
        "status",
        "payment_percentage",
        "umrah_block",
        "status_date_time",
        "flight_number",
        "from_city_id",
        "to_city_id",
        "one_way_or_return",
        "out_bound_date",
        "in_bound_date",
        "one_way_departure_time",
        "one_way_arrival_time",
        "return_departure_time",
        "return_arrival_time",
        "cost_price",
        "seats",
        "extra_flight_code1",
        "extra_trancend_date",
        "extra_from_city_id1",
        "extra_to_city_id1",
        "extra_r_flight_code1",
        "extra_r_trancend_date",
        "extra_r_from_city_id1",
        "extra_r_to_city_id1",
        "extra_one_way_departure_time1",
        "extra_one_way_arrival_time1",
        "extra_return_departure_time1",
        "extra_return_arrival_time1",
        "extra_flight_code2",
        "extra_from_city_id2",
        "extra_to_city_id2",
        "extra_r_flight_code2",
        "extra_r_from_city_id2",
        "extra_r_to_city_id2",
        "extra_one_way_departure_time2",
        "extra_one_way_arrival_time2",
        "extra_return_departure_time2",
        "extra_return_arrival_time2",
        "available_seats"
	];
    
    public function airline()
	{
		return $this->belongsTo(\App\TasksModels\Airline::class, 'airlines_id');
	}

	public function fromCity()
	{
		return $this->belongsTo(\App\TasksModels\City::class, 'from_city_id');
	}

	public function toCity()
	{
		return $this->belongsTo(\App\TasksModels\City::class, 'to_city_id');
	}

	public function blockedSeats()
	{
		return $this->hasMany(\App\TasksModels\BlockedSeat::class, 'airlineblockingdetails_id');
	}

	public function party()
	{
		return $this->belongsTo(\App\TasksModels\Party::class, 'parties_id');
	}
}
