<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $plan_id
 * @property string $price
 * @property string $discount_percentage
 * @property string $discount_start_date
 * @property string $discount_end_date
 * @property string $isDiscountActive
 * @property string $active
 * @property string $created_at
 * @property string $updated_at
 * @property Plan $plan
 */
class PlansPriceDiscount extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'plans_price_discount';

    /**
     * @var array
     */
    protected $fillable = ['plan_id', 'price', 'discount_percentage', 'discount_start_date', 'discount_end_date', 'isDiscountActive', 'active', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }
}
