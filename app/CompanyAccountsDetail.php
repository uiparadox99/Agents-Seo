<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $account_title
 * @property string $account_number
 * @property string $bank_name
 * @property string $created_at
 * @property string $updated_at
 */
class CompanyAccountsDetail extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'company_accounts_detail';

    /**
     * @var array
     */
    protected $fillable = ['account_title', 'account_number', 'bank_name', 'created_at', 'updated_at'];

}
