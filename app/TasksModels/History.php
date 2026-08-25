<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
	public $timestamps = false;
    public $table = "history";

    protected $fillable =  [
    	"remarks",
    	"activity_description 	",
    	"type",
    	"airline_block_id",
    	"blocked_seat_id",
    	"data",
    	"datetime ",
    	"agents_id",
    ];

}
