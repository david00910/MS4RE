<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\User;
use App\Property;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use SoftDeletes;

    public function __construct() {
        $this->middleware('auth');

    }

    protected function index() {
        if(Auth::user()->is_admin === 1) {
            return view('model.admin_dashboard.admin-dashboard');
        }
        else {

            $msg = 'Unauthorized';

            return view('model.admin_dashboard.admin-dashboard')->with([
                'msg' => $msg
            ],403);
        }
    }

    protected function indexProperties() {

        try {

            $property = Property::with('files')->with('propertycategories')->with('address')->orderBy('created_at', 'ASC')->paginate(6);

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

    protected function editUser(Request $request) {

        $authUser = Auth::user();

        if($authUser->is_admin === 1) {

            $user = $request->user;

            $v = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'phone' => 'required|max:16',

            ]);
            if ($v->fails()) {
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


            } catch (Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $e->errors()
                ], 400);

            }

            return response()->json(['status' => "You have successfully edited this user's details"], 200);

        }

        else {
            return response()->json([
                'status' => 'Access denied'
            ], 403);
        }

    }

    protected function editProperty($id, Request $request) {

        Validator::make($request->all(), [
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

            $property = Property::find($id);
            $property->description = $request->description;
            $property->price = $request->price;
            $property->brutto = $request->brutto;
            $property->netto = $request->netto;
            $property->own_exp = $request->own_exp;
            $property->deposit = $request->deposit;
            $property->sqm_price = $request->sqm_price;
            $property->save();
            DB::commit();

            return response()->json([
                'status' => 'You have successfully edited the property.',
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

    protected function deleteUser( Request $request) {

        $authUser = Auth::user();

        if($authUser->is_admin === 1) {

            $user = $request->user;

            if ($user->delete()) {

                return response()->json(['msg' => 'User account deleted successfully.'], 200);
            } else {
                return response()->json(['msg' => 'Error.'], 500);
            }
        }

        else {
            return response()->json([
                'status' => 'Access denied'
            ], 403);
        }


    }

    protected function deleteProperty($id, Request $request) {

        $authUser = Auth::user();
        if($authUser->is_admin === 1) {

            $property = Property::find($id);

            if ($property->delete()) {

                return response()->json(['msg' => 'Property deleted successfully. Please stand by while the list is reloading..'], 200);
            } else {
                return response()->json(['msg' => 'Error.'], 500);
            }
        }

        else {
            return response()->json([
                'status' => 'Access denied'
            ], 403);
        }
    }

}
