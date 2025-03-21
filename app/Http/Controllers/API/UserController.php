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
        $users = User::where('role', '!=', 'admin')->get();
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
            'name' => 'required|max:40',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*\s).+$/',
            'repeatPassword' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user['password'] = bcrypt($user['password']);
        $user = User::create($user);
        $data['id'] = $user->id;
        $data['email'] = $user->email;

        return $this->sendResponse($data, 'User register successfully.');
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

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('BossLoot')->plainTextToken;


            $data['id'] = $user->id;
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['role'] = $user->role;
            $data['address_1'] = $user->adress_1;
            $data['address_2'] = $user->adress_2;
            $data['mobile_phone'] = $user->mobile_phone;
            $data['level'] = $user->level;
            $data['points'] = $user->points;
            $data['email_confirmed'] = $user->email_confirmed;
            $data['activated'] = $user->activated;
            $data['profile_picture'] = $user->profile_picture;
            $data['token'] = $token;

            return $this->sendResponse($data, 'User login successfully.');



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
            'name' => 'max:80',
            'email' => 'email|unique:users,email,' . $id,
            'mobile_phone' => 'nullable|regex:/^[0-9]{9}$/',
            'adress_1' => 'nullable|max:255',
            'adress_2' => 'nullable|max:255',
            'level' => 'integer|min:1|max:3',
            'points' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->mobile_phone = $input['mobile_phone'];
        $user->adress_1 = $input['adress_1'];
        $user->adress_2 = $input['adress_2'];
        $user->level = $input['level'];
        $user->points = $input['points'];
        $user->email_confirmed = $input['email_confirmed'];
        $user->activated = $input['activated'];
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

        $user->delete();

        return $this->sendResponse([], 'User deleted successfully.');
    }
}
