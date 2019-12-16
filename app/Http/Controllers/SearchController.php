<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Property;
use Laravel\Scout\Searchable;
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
        $depositMin = $request->queryDepositFrom;
        $depositMax = $request->queryDepositTo;
        $category = $request->queryCategory;
        $expression = $request->queryExpression;

        $fromAdmin = $request->fromAdmin;


        try {
            if($request->queryCategory !== null) {
                $property = Property::with('files')->with('propertycategories')->with('address')->orderBy('price', 'ASC')
                    ->whereBetween('price', [$priceMin, $priceMax])
                    ->WhereBetween('brutto', [$bruttoMin, $bruttoMax])
                    ->WhereBetween('netto', [$nettoMin, $nettoMax])
                    ->WhereBetween('own_exp', [$ownExpMin, $ownExpMax])
                    ->WhereBetween('sqm_price', [$sqmMin, $sqmMax])
                    ->WhereBetween('deposit', [$depositMin, $depositMax])
                    ->whereHas('propertycategories', function ($q) use ($category) {
                        $q->whereIn('category', $category);
                    })
                    ->paginate(6);
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
            elseif ($request->queryExpression !== null) {
                $property = Property::with('files')->with('propertycategories')->with('address')->orderBy('price', 'ASC')
                    ->whereBetween('price', [$priceMin, $priceMax])
                    ->WhereBetween('brutto', [$bruttoMin, $bruttoMax])
                    ->WhereBetween('netto', [$nettoMin, $nettoMax])
                    ->WhereBetween('own_exp', [$ownExpMin, $ownExpMax])
                    ->WhereBetween('sqm_price', [$sqmMin, $sqmMax])
                    ->WhereBetween('deposit', [$depositMin, $depositMax])

                    ->whereHas('address', function ($q) use ($expression) {
                        $q->where('fulladdress', 'LIKE', "%{$expression}");
                        $q->orWhere('street', 'LIKE', "%{$expression}%");
                        $q->orWhere('door', 'LIKE', "%{$expression}%");
                        $q->orWhere('floor', 'LIKE', "%{$expression}%");
                        $q->orWhere('housenr', 'LIKE', "%{$expression}%");
                        $q->orWhere('postcode', 'LIKE', "%{$expression}%");
                        $q->orWhere('city', 'LIKE', "%{$expression}%");
                    })
                    ->paginate(6);
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
            elseif ($fromAdmin == 1 && $request->queryExpression !== null) {
                $property = Property::with('files')->with('propertycategories')->with('address')->orderBy('price', 'ASC')
                    ->whereHas('address', function ($q) use ($expression) {
                        $q->where('fulladdress', 'LIKE', "%{$expression}");
                        $q->orWhere('street', 'LIKE', "%{$expression}%");
                        $q->orWhere('door', 'LIKE', "%{$expression}%");
                        $q->orWhere('floor', 'LIKE', "%{$expression}%");
                        $q->orWhere('housenr', 'LIKE', "%{$expression}%");
                        $q->orWhere('postcode', 'LIKE', "%{$expression}%");
                        $q->orWhere('city', 'LIKE', "%{$expression}%");
                    })
                    ->paginate(6);
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
            elseif ($fromAdmin == 1) {
                $property = Property::with('files')->with('propertycategories')->with('address')->orderBy('price', 'ASC')->paginate(6);
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
            elseif ($request->queryExpression !== null && $request->queryCategory !== null) {
                $property = Property::with('files')->with('propertycategories')->with('address')->orderBy('price', 'ASC')
                    ->whereBetween('price', [$priceMin, $priceMax])
                    ->WhereBetween('brutto', [$bruttoMin, $bruttoMax])
                    ->WhereBetween('netto', [$nettoMin, $nettoMax])
                    ->WhereBetween('own_exp', [$ownExpMin, $ownExpMax])
                    ->WhereBetween('sqm_price', [$sqmMin, $sqmMax])
                    ->WhereBetween('deposit', [$depositMin, $depositMax])

                    ->whereHas('address', function ($q) use ($expression) {
                        $q->where('fulladdress', 'LIKE', "%{$expression}");
                        $q->orWhere('street', 'LIKE', "%{$expression}%");
                        $q->orWhere('door', 'LIKE', "%{$expression}%");
                        $q->orWhere('floor', 'LIKE', "%{$expression}%");
                        $q->orWhere('housenr', 'LIKE', "%{$expression}%");
                        $q->orWhere('postcode', 'LIKE', "%{$expression}%");
                        $q->orWhere('city', 'LIKE', "%{$expression}%");
                    })
                    ->whereHas('propertycategories', function ($q) use ($category) {
                        $q->whereIn('category', $category);
                    })
                    ->paginate(6);
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
            else {
                $property = Property::with('files')->with('propertycategories')->with('address')->orderBy('price', 'ASC')
                    ->whereBetween('price', [$priceMin, $priceMax])
                    ->WhereBetween('brutto', [$bruttoMin, $bruttoMax])
                    ->WhereBetween('netto', [$nettoMin, $nettoMax])
                    ->WhereBetween('own_exp', [$ownExpMin, $ownExpMax])
                    ->WhereBetween('sqm_price', [$sqmMin, $sqmMax])
                    ->WhereBetween('deposit', [$depositMin, $depositMax])

                    ->paginate(6);
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


}
