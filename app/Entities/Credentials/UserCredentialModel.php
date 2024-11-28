<?php

namespace App\Entities\Credentials;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Entities\Users\Profile\UserProfileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserCredentialModel extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'user_credentials';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       // 'name',
       // 'email',
    //'password',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    /*
    protected $hidden = [
        'password',
        'remember_token',
    ];
    */

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    /*
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    */

    public function getAuthPassword()
    {
        return $this->pass_hash;
    }

    public function userProfile(): HasOne
    {
        return $this->hasOne(UserProfileModel::class, 'credential_id');
    }
}
