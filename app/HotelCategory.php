<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $show_home
 */
class HotelCategory extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'show_home'];

}
