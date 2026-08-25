<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $countries_id
 * @property string $report_date
 * @property string $passenger_name
 * @property int $parties_id
 * @property int $suppliers_id
 * @property string $phone
 * @property string $days
 * @property string $cost
 * @property string $sale
 * @property string $profit
 * @property string $remarks
 * @property string $created_at
 * @property string $updated_at
 * @property Country $country
 */
class TravelInsurance extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'travel_insurance_sale';

    /**
     * @var array
     */
    protected $fillable = ['countries_id', 'report_date', 'passenger_name', 'parties_id', 'suppliers_id', 'phone', 'days', 'cost', 'sale', 'profit', 'remarks', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country', 'countries_id');
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
