<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Address extends Model
{
    use Searchable;
    protected $table = 'addresses';

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return array('id' => $array['id'], 'fulladdress' => $array['fulladdress'], 'city' => $array['city'], 'street' => ['street']);
    }


}
