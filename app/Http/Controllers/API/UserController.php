<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends BaseController
{
    /**
     * Retrieves a list of users.
     */
    public function index()
    {
        $users = User::all();
        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->all();
        $validator = Validator::make($user, [
            'name' => 'required|max:60',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*\s).+$/',
            'c_password' => 'required|same:password',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user['password'] = bcrypt($user['password']);
        $user = User::create($user);
        $success['token'] =  $user->createToken('BossLoot')->plainTextToken;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login a user.
     */
    public function login(Request $request)
    {
        $credentials = $request->all();
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $success['token'] =  $user->createToken('BossLoot')->plainTextToken;
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Invalid credentials.']);
        }
    }

    /**
     * Retrieve the specified user.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if ($user == null) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if ($user == null) {
            return $this->sendError('User not found.');
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|max:60',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->role = $input['role'];
        $user->save();

        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user == null) {
            return $this->sendError('User not found.');
        }

        $user->deleted = true;
        $user->save();

        return $this->sendResponse([], 'User deleted successfully.');
    }
}
