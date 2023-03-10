<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class AuthController extends BaseController
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error Validation', $validator->errors(), 400);
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        // password lai encrypt gareko with the help of hash funciton
        $password = Hash::make($password);
        $ldate = date('Y-m-d H:i:s');

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->email_verified_at = $ldate;

        $user->save();

        $success['token'] =  $user->createToken('l9PassportAuth')->accessToken;
        $success['user'] =  $user;

        return $this->sendResponse($success, 'User created successfully.', 200);
    }

    public function doctorRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error Validation', $validator->errors(), 400);
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        // password lai encrypt gareko with the help of hash funciton
        $password = Hash::make($password);
        $ldate = date('Y-m-d H:i:s');

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->is_doctor = 'Y';
        $user->password = $password;
        $user->email_verified_at = $ldate;

        $user->save();

        $success['token'] =  $user->createToken('l9PassportAuth')->accessToken;
        $success['user'] =  $user;

        return $this->sendResponse($success, 'Doctor created successfully.', 200);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error Validation', $validator->errors(), 400);
        }
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = Auth::user();

            //ignore that createToken error
            $success['token'] =  $user->createToken('l9PassportAuth')->accessToken;
            $success['user'] =  $user;


            return $this->sendResponse($success, 'User Login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Credettials doesnot match']);
        }
    }
}
