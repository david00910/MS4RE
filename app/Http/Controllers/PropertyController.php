<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\PropertyCategories;
use Illuminate\Database;
use App\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function __construct()
    {

    }

    protected function indexData()
    {
        $client = new Client();
        //$response = $client->request('GET', '');// @TODO: Write a script that retrieves data per property from the API based on UnitID, which gets saved in the database on property registration.
        //$statusCode = $response->getStatusCode();
        $body = 'bab';//$response->getBody()->getContents();

        //dd($body);

        try {
            $property = Property::with('files')->with('propertycategories')->orderBy('created_at', 'ASC')->paginate(12);
            $response = [
                'pagination' => [
                    'total' => $property->total(),
                    'per_page' => $property->perPage(),
                    'current_page' => $property->currentPage(),
                    'last_page' => $property->lastPage(),
                    'from' => $property->firstItem(),
                    'to' => $property->lastItem()
                ],
                'data' => $property,
                'bbr' => $body
            ];
        }
        catch (Exception $e) {
            return response()->json([
                'status' => $e
            ], 400);
        }

        return response()->json(
          $response, 200
        );
    }

    protected function create() {

        return view('model.property.create');
    }

    protected function store(Request $request) {

        $user = Auth::user()->getAuthIdentifier();

        Validator::make($request->all(), [
            'address_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'brutto' => 'required',
            'netto' => 'required',
            'own_exp' => 'required',
            'deposit' => 'required',
            'sqm_price' => 'required',
        ]);


        try {

            $property = new Property();
            $property->address_id = $request->address_id;
            $property->description = $request->description;
            $property->price = $request->price;
            $property->brutto = $request->brutto;
            $property->netto = $request->netto;
            $property->own_exp = $request->own_exp;
            $property->deposit = $request->deposit;
            $property->sqm_price = $request->sqm_price;
            $property->created_by = $user;
            $property->save();


        }

        catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => $e
            ], 400);

        }

        return response()->json(['status' => 'You have successfully created your property for sale. We will contact you shortly.'], 200);


    }

}
