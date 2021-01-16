<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'adress' => 'required|string',
            'sexe' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'age' => $request->get('age'),
            'adress' => $request->get('adress'),
            'sexe' => $request->get('sexe'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getCode());
        }
        return $user;
    }

    public function delete()
    {
        $user = $this->getAuthenticatedUser();
        $user->delete();
        return response()->json('user deleted', 200);
    }

    public function update(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        $name = $request->get('name');
        $age = $request->get('age');
        $adress = $request->get('adress');
        if ($name != "")
            $user->name = $name;
        if ($age != "")
            $user->age = $age;
        if ($adress != "")
            $user->adress = $adress;
        $user->save();
        return response()->json('user updated', 200);
    }


    public function deleteUser($id)
    {
        $user = $this->getAuthenticatedUser();
        if ($user->type == "admin") {
            $user1 = User::find($id);
            $user1->delete();
            return response()->json('user deleted', 200);
        } else
            return response()->json('you are not an admin', 400);
    }

    public function updateUser($id, Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if ($user->type == "admin") {
            $user1 = User::find($id);
            $name = $request->get('name');
            $age = $request->get('age');
            $adress = $request->get('adress');
            if ($name != "")
                $user1->name = $name;
            if ($age != "")
                $user1->age = $age;
            if ($adress != "")
                $user1->adress = $adress;
            $user1->save();
            return response()->json('user updated', 200);
        } else
            return response()->json('you are not an admin', 400);
    }

    public function allUsers()
    {
        $user = $this->getAuthenticatedUser();
        if ($user->type == "admin")
            return User::all();
        else
            return response()->json('you are not an admin', 400);
    }
}
