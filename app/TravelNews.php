<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $airlines_id
 * @property string $title
 * @property string $image
 * @property string $image_alt
 * @property string $content
 * @property string $slug
 * @property string $meta_title
 * @property string $meta_description
 * @property string $is_featured
 * @property string $created_at
 * @property string $updated_at
 * @property Airline $airline
 */
class TravelNews extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['airlines_id', 'title', 'image', 'image_alt', 'content', 'slug', 'meta_title', 'meta_description', 'is_featured', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function airline()
    {
        return $this->belongsTo('App\Airlines', 'airlines_id');
    }
}
