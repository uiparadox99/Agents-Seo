<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_reviews';

    protected $fillable = [
        'product_type',
        'product_id',
        'user_id',
        'name',
        'rating',
        'comment',
        'approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'approved' => 'boolean',
    ];

    /**
     * Scope query to only approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('approved', 1);
    }

    /**
     * Umrah package relationship.
     */
    public function package()
    {
        return $this->belongsTo('App\Packages', 'product_id');
    }

    /**
     * Tour package relationship.
     */
    public function tourPackage()
    {
        return $this->belongsTo('App\TourPackages', 'product_id');
    }

    /**
     * User relationship (if review submitted by logged in user).
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
