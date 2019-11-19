<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\User;
use App\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SelfServiceController extends Controller
{
    use SoftDeletes;

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

    protected function storeEditUser(Request $request) {

        $user = Auth::user();

        $v = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone' => 'required|max:16',

        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        try {

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->save();


        }

        catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 400);

        }

        return response()->json(['status' => 'You have successfully edited your user details'], 200);

    }

    protected function storeSoftDeleteUser() {

        $user = Auth::user();

        if ($user->delete()) {

             return response()->json(['msg' => 'Account deleted successfully. We hate to see you go.'], 200);
        }
        else {
            return response()->json(['msg' => 'Error. We could not delete your account. Please try again or contact us!'], 500);
        }


    }

}
