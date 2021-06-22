<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
//use Illuminate\Support\Facades\Hash; for password hashing


class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        $size = $request->query('size');
        $users = $query->get();
        if ($size) {
            $users = $query->paginate($size);
        }
        return UserResource::collection($users);
    }

    public function register(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "fName" => 'required|string|min:3|max:50',
                "lName" => 'required|string|min:3|max:50',
                "email" => 'required|string|min:5|max:30|unique:users',
                "studId" => 'required|string|min:3|max:25|unique:users',
                "tel" => 'numeric|min:8',
                "idCourse" => 'required|numeric'
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->failed(), 400);
        }

        $user = User::create($request->all());
        if ($user) {
            $token = $user->createToken("$user->lName.'token'")->plainTextToken;
            $response = ['user' => $user, 'token' => $token];
            return [new UserResource($user),response($response,201)];
        }
        throw new Exception('Unexpected Error');
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }

    public function show($id)
    {
        $user = User::find($id);
        if (! $user) {
            return response()->json(['error' => 'Unrecognised ID'], 400);
        }
        return new UserResource($user);
    }

    public function getByStudId($studId){

        $user = User::where('studId', $studId)->first();
        if (! $user) {
            return response()->json(['error' => 'studId'], 400);
        }
        return new UserResource($user);
    }

    public function getByFName($name){

        $user = User::where('fName','like', '%'.$name.'%')->first();
        if (! $user) {
            return response()->json(['error' => 'first Name'], 400);
        }
        return new UserResource($user);
    }

    public function getByLName($name){

        $user = User::where('lName','like', '%'.$name.'%')->first();
        if (! $user) {
            return response()->json(['error' => 'Last name'], 400);
        }
        return new UserResource($user);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "id" => 'required|numeric|unique:users'. $id,
                "fName" => 'required|string|min:3|max:50',
                "lName" => 'required|string|min:3|max:50',
                "email" => 'required|string|min:5|max:30|unique:users',
                "studId" => 'required|string|min:3|max:25|unique:users',
                "admin" => 'required|boolean',
                "tel" => 'required|numeric|min:8',
                "idCourse" => 'required|numeric'
            ]);

        if ($validate->fails()) {
            return response()->json($validate->failed(), 400);
        }

        if ($id->update($request->all())) {
            $id->flash();
            return new UserResource($id);
        }

        throw new Exception('Unexpected Error');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            return ['data' => $id];
        }
        throw new Exception('Unexpected Error');
    }

    public function login(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "email" => 'required|string|min:5|max:30',
                "studId" => 'required|string|min:3|max:25',
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->failed(), 400);
        }

        // check email
        $user = User::where('email',$request->email)->first();

        if(! $user)
            return response(
                ['message' => 'Unknown Email'], 400
            );

        $id = $user->studId == $request->studId;

        if (! $user || ! $id){
            return response(
                ['message' => 'Invalid Entries'], 400
            );
        }
        $token = $user->createToken("$user->email.'token'")->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return response($response,201);


        throw new Exception('Unexpected Error');
    }

}
