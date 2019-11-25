<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Property;
use App\PropertyCategories;


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
        $category = $request->queryCategory;


        try {
            if($request->queryCategory !== null) {
                $property = Property::with('files')->with('propertycategories')->orderBy('price', 'ASC')
                    ->whereBetween('price', [$priceMin, $priceMax])
                    ->WhereBetween('brutto', [$bruttoMin, $bruttoMax])
                    ->WhereBetween('netto', [$nettoMin, $nettoMax])
                    ->WhereBetween('own_exp', [$ownExpMin, $ownExpMax])
                    ->WhereBetween('sqm_price', [$sqmMin, $sqmMax])
                    ->whereHas('propertycategories', function ($q) use ($category) {
                        $q->whereIn('category', $category);
                    })
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
            else { // @TODO: LATER FIND A BETTER SOLUTION FOR CHECKING IF THERE IS A CATEGORY REQUEST!!!
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
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error: '.$e]);
        }

        return response()->json($response);
    }

    /*protected function getCategories() {
        try {
            $categories = PropertyCategories::all();

            return response()->json($categories);
        }
        catch (Exception $e) {
            return response()->json($e);
        }
    }*/
}
