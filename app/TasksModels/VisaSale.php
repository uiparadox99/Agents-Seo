<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $visa_types_id
 * @property int $countries_id
 * @property string $report_date
 * @property string $passenger_name
 * @property int $parties_id
 * @property int $suppliers_id
 * @property string $phone
 * @property string $cost
 * @property string $sale
 * @property string $profit
 * @property string $remarks
 * @property string $created_at
 * @property string $updated_at
 * @property Country $country
 * @property VisaType $visaType
 */
class VisaSale extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'visa_sale';

    /**
     * @var array
     */
    protected $fillable = ['visa_types_id', 'countries_id', 'report_date', 'passenger_name', 'parties_id', 'suppliers_id', 'phone', 'cost', 'sale', 'profit', 'remarks','agents_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country', 'countries_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visaType()
    {
        return $this->belongsTo('App\TasksModels\VisaTypes', 'visa_types_id');
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
