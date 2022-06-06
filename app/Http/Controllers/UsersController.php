<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UserValidationRules;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    use UserValidationRules;

    public function show(Request $request)
    {
        return Inertia::render('App/AdminCentre/Users', ['users' => User::all(['id', 'first_name', 'last_name', 'email', 'district_id', 'created_at', 'last_signed_in_at', 'email_verified_at'])->keyBy('id'), 'districts' => District::all(['id', 'name'])->keyBy('id')]);
    }

    public function create(Request $request)
    {
        $input = $request->all();

        Validator::make($input, $this->rules())->validate();
        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'district_id' => $input['district'],
        ]);

        if ($user === null) abort(500);

        $user->email_verified_at = now();
        $user->save();

        return Redirect::back();
    }

    public function patch(Request $request, int $id)
    {
        $user = User::find($id);
        if ($user === null) abort(400);

        $input = $request->all();

        Validator::make($input, $this->rules(false, false))->validate();
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->district_id = $input['district'];
        $user->save();

        return Redirect::back();
    }

    public function delete(Request $request, $id)
    {
        $success = User::destroy($id);
        if ($success) return response(null, 200);
        else abort(500);
    }

    public function reset_password(Request $request, $id)
    {
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        return response(null, 200);
    }
}
