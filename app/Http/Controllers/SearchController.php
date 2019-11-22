<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;


class SearchController extends Controller
{
    protected function search(Request $request) {

        $queryMin = $request->queryPriceFrom;
        $queryMax = $request->queryPriceTo;

        try {
            $property = Property::whereBetween('price', [$queryMin, $queryMax])->with('files')->with('propertycategories')->orderBy('price', 'ASC')->paginate(12);
            $response = [
                'pagination' => [
                    'total' => $property->total(),
                    'per_page' => $property->perPage(),
                    'current_page' => $property->currentPage(),
                    'last_page' => $property->lastPage(),
                    'from' => $property->firstItem(),
                    'to' => $property->lastItem()
                ],
                'data' => $property
            ];
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error: '.$e]);
        }

        return response()->json($response);
    }
}
