<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';

    protected $fillable = ['description', 'price', 'brutto', 'netto', 'own_exp', 'deposit', 'sqm_price' ];
}
