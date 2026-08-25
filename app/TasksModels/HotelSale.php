<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $room_types_id
 * @property string $report_date
 * @property string $passenger_name
 * @property string $hotel_name
 * @property string $phone
 * @property string $check_in
 * @property string $check_out
 * @property string $cost
 * @property string $sale
 * @property string $profit
 * @property string $remarks
 * @property string $created_at
 * @property string $updated_at
 * @property int $parties_id
 * @property int $suppliers_id
 * @property RoomType $roomType
 */
class HotelSale extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hotel_sale';

    /**
     * @var array
     */
    protected $fillable = ['room_types_id', 'report_date', 'passenger_name', 'hotel_name', 'phone', 'check_in', 'check_out', 'cost', 'sale', 'profit', 'remarks', 'created_at', 'updated_at', 'parties_id', 'suppliers_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roomType()
    {
        return $this->belongsTo('App\TasksModels\RoomTypes', 'room_types_id');
    }

    public function party()
    {
        return $this->belongsTo('App\TasksModels\Vendee', 'parties_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\TasksModels\Vendee', 'suppliers_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo('App\Agents', 'agents_id');
    }

}
