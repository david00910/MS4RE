<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Property;
use Illuminate\Support\Facades\Auth;

class SelfServiceController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    protected function index() {
        return view('model.self_service.self_service');
    }

    protected function indexMyProperties() {

        $user = Auth::user()->id;

        try {
            $property = Property::with('files')->with('propertycategories')->orderBy('created_at', 'ASC')->where('created_by', $user)->paginate(2);
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
                'status' => $e
            ], 400);
        }

        return response()->json(
            $response, 200
        );


    }

}
