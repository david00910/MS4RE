<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Resources\PropertyResource;
use App\PropertyFiles;
use Illuminate\Http\Request;
use App\Property;
use App\PropertyCategories;
use Illuminate\Database;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
            'uploadFile[]' => 'file|mimes:png,jpg|max:4000000'
        ]);



        DB::beginTransaction();

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
            $address->coordinate_y = $request->y;
            $address->coordinate_x = $request->x;
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

            // File upload

                $photo = $request->input('uploadFile');

                $storagePaths = [];

                    $originalImage = Image::make($photo)->orientate();

                    /**
                     * HD image
                     */
                    $HDImage = Image::make($originalImage)->resize(null, 1080, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $HDImagePath = $photo->hashName('images/property/' . $property->id . '/2k');

                    Storage::put($HDImagePath, $HDImage->encode('jpg', 75));
                    $storagePaths[] = $HDImagePath;

                    /**
                     * Thumbnail image
                     */
                    $thumbImage = Image::make($HDImage)->fit(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $thumbImagePath = $photo->hashName('images/meta/' . $property->id . '/thumbnail');

                    Storage::put($thumbImagePath, $thumbImage->encode('jpg', 75));
                    $storagePaths[] = $thumbImagePath;

                    $file = new PropertyFiles();
                    $file->property_id = $property->id;
                    $file->type = 'image';
                    $file->name = $file->hashName();
                    $file->filetype = $originalImage->mime();
                    if ($storagePaths[0]) {
                        $file->url = $HDImagePath;
                    } elseif ($storagePaths[1]) {
                        $file->url = $thumbImagePath;
                    }
                    if (!$file->save()) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'An image could not be saved. Please try again'
                        ]);
                    }


                    DB::commit();



           return response()->json(['status' => 'You have successfully created your property for sale. We will contact you shortly.'], 200);

        }

        catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => $e->getCode(),
                'msg' => $e->getMessage()
            ], 400);

        }

    }

    protected function show() {

        return view('model.property.show');

    }

    protected function singlePropertyData($id) {

        try {

            $property = Property::with('address')->find($id);

            $address_id = $property->address->address_uuid;

            $client = new Client();
            $response = $client->request('GET', 'https://dawa.aws.dk/bbrlight/enheder?adresseid='.$address_id);
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
