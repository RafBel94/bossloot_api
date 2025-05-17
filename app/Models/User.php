<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\CustomVerifyEmail;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'adress_1',
        'adress_2',
        'mobile_phone',
        'role',
        'level',
        'points',
        'profile_picture',
        'activated',
        'email_confirmed'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Method to verify if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Method to verify if user is user
    public function isUser()
    {
        return $this->role === 'user';
    }

    // Get user verification URL
    public function sendEmailVerificationNotification()
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify', now()->addMinutes(60), ['id' => $this->id, 'hash' => sha1($this->email)]
        );

        try {
            Mail::to($this->email)->send(new CustomVerifyEmail($verificationUrl, $this));
            logger()->info('Verification email sent to user ID ' . $this->id);
        } catch (\Exception $e) {
            logger().info('Failed to send verification email to user ID ' . $this->id . ': ' . $e->getMessage());
        }
    }

    // Get all valorations that the user has made
    public function valorations()
    {
        return $this->hasMany(Valoration::class);
    }

    // Get all favorites that the user has made
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Get discount the user has depending on the level
    public function getDiscount()
    {
        switch ($this->level) {
            case 1:
                return 0;
            case 2:
                return 0.05;
            case 3:
                return 0.10;
            case 4:
                return 0.15;
            default:
                return 0;
        }
    }

    // Check if the user has enough points to level up and tries to do so
    public function TryLevelUp()
    {
        $points = $this->points;

        if ($points >= 800) {
            $this->level = 4;
        } else if ($points >= 500) {
            $this->level = 3;
        } else if ($points >= 300) {
            $this->level = 2;
        } else {
            return false;
        }
    }

}
