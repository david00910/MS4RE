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

            $property = Property::with('files')->with('creator')->with('propertycategories')->with('address')->orderBy('price', 'ASC')->paginate(6);
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
            DB::commit();

           return response()->json([
               'status' => 'You have successfully created your property for sale. We will contact you shortly.',
               'id' => $property->id
           ], 200);

        }

        catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => $e->getCode(),
                'msg' => $e->getMessage()
            ], 400);

        }

    }

    protected function storeImage(Request $request) {


        /*Validator::make($request->all(), [

            'uploadFile[]' => 'file|mimes:png,jpg|max:4000000'

        ]);*/

        DB::beginTransaction();

        try {


            // File upload

            $property = $request->propertyId;

            $photo = $request->file('file');
            $storagePaths = [];

                $originalImage = Image::make($photo)->orientate();

                /**
                 * HD image
                 */
                $HDImage = Image::make($originalImage)->resize(2048, 1920, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $HDImagePath = $photo->hashName('public/images/property/' . $property . '/2k');
                $HDPathToSave =$photo->hashName('images/property/' . $property . '/2k');

                Storage::disk('local')->put($HDImagePath, $HDImage->encode('jpg', 75));
                array_push($storagePaths, $HDImagePath);


                /**
                 * Thumbnail image
                 */
                $thumbImage = Image::make($HDImage)->resize(600, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbImagePath = $photo->hashName('public/images/property/' . $property . '/thumbnail');
            $thumbPathToSave =$photo->hashName('images/property/' . $property . '/thumbnail');

                Storage::disk('local')->put($thumbImagePath, $thumbImage->encode('jpg', 75));
                array_push($storagePaths, $thumbImagePath);

                $file = new PropertyFiles();
                $file->property_id = $property;
                $file->type = 'image';
                $file->name = $photo->hashName();
                $file->filetype = $originalImage->mime();
                $file->url = $HDPathToSave;
                $file->thumbnail_url = $thumbPathToSave;
                if (!$file->save()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'An image could not be saved. Please try again'
                    ]);
                }

                DB::commit();




            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully upload the image(s).'
            ]);

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

            $property = Property::with('address')->with('files')->find($id);

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
