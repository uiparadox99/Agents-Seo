<?php

namespace App\TasksModels;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $iso2
 * @property string $short_name
 * @property string $long_name
 * @property string $iso3
 * @property string $numcode
 * @property string $un_member
 * @property string $calling_code
 * @property string $cctld
 * @property TourPackage[] $tourPackages
 * @property TravelInsuranceSale[] $travelInsuranceSales
 * @property VisaSale[] $visaSales
 */
class Country extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['iso2', 'short_name', 'long_name', 'iso3', 'numcode', 'un_member', 'calling_code', 'cctld'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tourPackages()
    {
        return $this->hasMany('App\TasksModels\TourPackage', 'countries_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function travelInsuranceSales()
    {
        return $this->hasMany('App\TasksModels\TravelInsurance', 'countries_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visaSales()
    {
        return $this->hasMany('App\TasksModels\VisaSale', 'countries_id');
    }
}
