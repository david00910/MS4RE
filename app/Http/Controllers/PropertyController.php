<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use Illuminate\Database;
use Exception;

class PropertyController extends Controller
{
    public function __construct()
    {

    }

    protected function indexData()
    {
        try {
            $property = Property::all();
        }
        catch (Exception $e) {
            return response()->json($e);
        }

        return response()->json(
          $property
        );
    }
}
