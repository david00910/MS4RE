<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyCategories extends Model
{
    protected $table = 'property_categories';

    protected $fillable = ['description', 'category'];

    protected function properties() {
        return $this->belongsToMany('App\Property', 'property_has_categories', 'cat_id', 'prop_id');
    }
}
