<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
    }

    public function index(Request $request){
        $user = $request->user();
        return $user;
    }

    public function update(Request $request){
        $user = $request->user();

        $user->fill($request->only($user->getFillable()));

        $user->save();

        return $this->responseSuccess(Lang::get('users.profile.updated'), ['data' => $user]);
    }

    public function changePassword(Request $request){
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'old_password' => ['required'],
        ]);

        extract($request->all());

        $user = $request->user();

        if(Hash::check($old_password, $user->password)){
            $user->password = Hash::make($password);
            $user->save();

            return $this->responseSuccess(Lang::get("passwords.reset"));
        }

        return $this->responseWithError(['password' => Lang::get("validation.password_match")]);
    }

    public function emailExist(Request $request){
        $user = User::whereEmail($request->email)->first();

        if(!$user) return $this->responseWithError(['error' => Lang::get('passwords.user'), "exist" => false]);

        return $this->responseSuccess("", ["exist" => true]);
    }

    public function checkIfCodeExist(Request $request){
        $request->validate(['email' => 'required', 'code' => 'required']);

        $user = User::whereEmail($request->email)->whereResetCode($request->code)->first();

        if(!$user) return $this->responseWithError(["code" => Lang::get('passwords.token')]);

        return $this->responseSuccess(Lang::get('passwords.code_matched'), [
            'code' => $user->reset_code,
            'token' => $user->plain_token
        ]);

    }

    public function doLogout(Request $request){
        $request->user()->token()->revoke();

        return $this->responseSuccess(Lang::get('auth.logout'));
    }

    public function getNotifications(Request $request){
        return $request->user()->notifications()->latest()->get();
    }
}
