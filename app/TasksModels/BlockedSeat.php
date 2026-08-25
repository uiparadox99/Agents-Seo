<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class BlockedSeat extends Model
{
	protected $fillable =  [
		"seat_no",
		"agents_id",
		"airlineblockingdetails_id",
		"passenger_name",
        "party_price",
        "agents_id",
		"advance",
		"balance",
		"remarks",
		"parties_id",
		"booking_date",
		"booking_time",
		"phone",
		"canNotEdit"];

		public $timestamps = false;

		public function remarks()
		{
			return $this->hasMany(\App\TasksModels\BlockedSeatRemark::class, 'blocked_seats_id');
		}

		
	}
