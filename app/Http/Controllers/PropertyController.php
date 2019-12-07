<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Resources\PropertyResource;
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

        try {

            $property = Property::with('files')->with('propertycategories')->with('address')->orderBy('created_at', 'DESC')->paginate(12);
            //$property = PropertyResource::collection(Property::orderBy('updated_at', 'DESC')->paginate(12));

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
        catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'msg' => $e->getMessage()
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
            'street' => 'required',
            'door',
            'floor',
            'housenr' => 'required',
            'postcode' => 'required',
            'city' => 'required',
            'description' => 'required',
            'price' => 'required',
            'brutto' => 'required',
            'netto' => 'required',
            'own_exp' => 'required',
            'deposit' => 'required',
            'sqm_price' => 'required',
        ]);


        try {

            $address = new Address();
            $address->address_uuid = $request->address_id;
            $address->street = $request->street;
            $address->fulladdress = $request->street.' '.$request->housenr.' '.$request->floor.' '.$request->door.' '.$request->postcode.' '.$request->city;
            $address->door = $request->door;
            $address->floor = $request->floor;
            $address->housenr = $request->housenr;
            $address->postcode = $request->postcode;
            $address->city = $request->city;
            $address->save();

            $property = new Property();
            $property->description = $request->description;
            $property->price = $request->price;
            $property->brutto = $request->brutto;
            $property->netto = $request->netto;
            $property->own_exp = $request->own_exp;
            $property->deposit = $request->deposit;
            $property->sqm_price = $request->sqm_price;
            $property->created_by = $user;
            $property->address_id = $address->id;
            $property->save();


        }

        catch(Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'msg' => $e->getMessage()
            ], 400);

        }

        return response()->json(['status' => 'You have successfully created your property for sale. We will contact you shortly.'], 200);


    }

    protected function show() {

        return view('model.property.show');

    }

    protected function singlePropertyData() {

        try {

            $property = Property::with('address')->find(2);

            $address_id = $property->address->address_uuid;

            $client = new Client();
            $response = $client->request('GET', 'https://dawa.aws.dk/bbrlight/enheder?adresseid='.$address_id.'&struktur=mini');
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            return response()->json([
                'data' => $property,
                'bbr' => json_decode($body)
            ]);

        }
        catch(Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'msg' => $e->getMessage()
            ], 400);
        }

    }

}
