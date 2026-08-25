<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $subscription_id
 * @property float $payment
 * @property int $discount_percentage
 * @property string $plan_price
 * @property string $account_title
 * @property int $account_number
 * @property string $bank_name
 * @property string $receiver_account_title
 * @property string $comment
 * @property string $transaction_date
 * @property string $expire_date
 * @property string $type
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Transaction extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['subscription_id', 'payment', 'discount_percentage', 'plan_price', 'account_title', 'account_number', 'bank_name', 'receiver_account_title', 'comment', 'transaction_date', 'expire_date', 'type', 'status', 'created_at', 'updated_at'];

}
