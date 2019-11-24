<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;


class SearchController extends Controller
{
    protected function search(Request $request) {

        $priceMin = $request->queryPriceFrom;
        $priceMax = $request->queryPriceTo;
        $bruttoMin = $request->queryBruttoFrom;
        $bruttoMax = $request->queryBruttoTo;
        $nettoMin = $request->queryNettoFrom;
        $nettoMax = $request->queryNettoTo;
        $ownExpMin = $request->queryOwnExpFrom;
        $ownExpMax = $request->queryOwnExpTo;
        $sqmMin = $request->querySqmPriceFrom;
        $sqmMax = $request->querySqmPriceTo;
        $category1 = $request->queryCategory1;
        $category2 = $request->queryCategory2;
        $category3 = $request->queryCategory3;
        $category4 = $request->queryCategory4;
        $category5 = $request->queryCategory5;

        try {
            $property = Property::with('files')->with('propertycategories')->orderBy('price', 'ASC')
                ->whereBetween('price', [$priceMin, $priceMax])
                ->WhereBetween('brutto', [$bruttoMin, $bruttoMax])
                ->WhereBetween('netto', [$nettoMin, $nettoMax])
                ->WhereBetween('own_exp', [$ownExpMin, $ownExpMax])
                ->WhereBetween('sqm_price', [$sqmMin, $sqmMax])
               ->paginate(12);
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
