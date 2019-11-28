<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\PropertyCategories;
use Illuminate\Database;
use Exception;
use GuzzleHttp\Client;

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

        /*$client = new Client();
        $response = $client->request('GET', '');// Getting the autocomplete function from the DAWA API.
        $statusCode = $response->getStatusCode();
        $body =  $response->getBody()->getContents();

        //dd($body);*/

        return view('model.property.create');
    }

    protected function bbrBaseUrl() {


    }
}
