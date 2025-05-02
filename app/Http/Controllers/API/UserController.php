<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateProfileRequest;


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

        // Send email confirmation
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            Log::error('Email verification error: ' . $e->getMessage());
        }

        return $this->sendResponse($data, 'User register successfully. Please confirm your email.');
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

            if ($user->activated == 0) {
                return $this->sendError('Unauthorized.', ['error' => 'User not activated. Please contact an admin.']);
            } else if ($user->email_confirmed == 0) {
                return $this->sendError('Unauthorized.', ['error' => 'Please confirm your email before logging in.']);
            }

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

        if ($user->role == 'admin') {
            return $this->sendError('Unauthorized.', ['error' => 'You cannot view this user.']);
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
    public function update(UpdateUserRequest $request, User $user)
    {
        logger()->info('Entered update method.');
        DB::transaction(function () use ($request, $user) {
            if ($request->hasFile('profile_picture')) {
                $this->deleteOldProfilePicture($user->profile_picture);

                $user->profile_picture = Cloudinary::upload(
                    $request->file('profile_picture')->getRealPath(),
                    [
                        'folder' => 'bossloot/user-images',
                    ]
                )->getSecurePath();
            }

            // Update fields - Laravel automatically handles null values for fields not present
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'mobile_phone' => $request->mobile_phone,
                'adress_1' => $request->adress_1,
                'adress_2' => $request->adress_2,
                'level' => (int) $request->level,
                'points' => (int) $request->points,
                'email_confirmed' => $request->email_confirmed,
                'activated' => $request->activated,
            ])->save();
        });

        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
    }

    /**
     * Update the user profile.
     */
    public function updateProfile(UpdateProfileRequest $request, String $id)
    {
        try {
            logger()->info('Entered updateProfile method.');
            $user = USER::find($id);

            DB::transaction(function () use ($request, $user) {
                if ($request->hasFile('profile_picture')) {
                    $this->deleteOldProfilePicture($user->profile_picture);

                    $user->profile_picture = Cloudinary::upload(
                        $request->file('profile_picture')->getRealPath(),
                        [
                            'folder' => 'bossloot/user-images',
                        ]
                    )->getSecurePath();
                }

                // Update fields - Laravel automatically handles null values for fields not present
                $user->fill([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile_phone' => $request->mobile_phone,
                    'address_1' => $request->adress_1,
                    'address_2' => $request->adress_2,
                ])->save();
            });

            return $this->sendResponse(new UserResource($user), 'User profile updated successfully.');
        } catch (\Exception $e) {
            logger()->error('Error updating user profile: ' . $e->getMessage());
            return $this->sendError('Error updating profile.', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Delete the old profile picture from Cloudinary.
     */
    protected function deleteOldProfilePicture(?string $url): void
    {
        // Dont delete the default image
        $defaultImage = 'https://res.cloudinary.com/dlmbw4who/image/upload/v1742850142/avatar-placeholder_qiq5pb.png';

        if (empty($url) || $url === $defaultImage) {
            return;
        }

        try {
            $publicId = $this->extractPublicIdFromUrl($url);

            if ($publicId) {
                Cloudinary::destroy($publicId);
            }
        } catch (\Exception $e) {
            \Log::error("Error deleting old profile picture: " . $e->getMessage());
        }
    }

    /**
     * Extract public ID from Cloudinary URL.
     */
    protected function extractPublicIdFromUrl(string $url): ?string
    {
        $pattern = '/upload\/(?:v\d+\/)?([^\.]+)/';
        preg_match($pattern, $url, $matches);

        return $matches[1] ?? null;
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

        if ($user->role == 'admin') {
            return $this->sendError('Unauthorized.', ['error' => 'You cannot delete this user.']);
        }

        $user->delete();

        return $this->sendResponse([], 'User deleted successfully.');
    }
}
