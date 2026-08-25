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
class Permissions extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
     public $timestamps = false;
    protected $table = 'permissions';

    /**
     * @var array
     */
  

}
