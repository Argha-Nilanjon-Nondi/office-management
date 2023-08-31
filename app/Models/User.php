<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasRoles,HasApiTokens,HasUuids, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function createToken(string $name, array $abilities = ['*'], DateTimeInterface $expiresAt = null)
    {
        $plainTextToken = sprintf(
            '%s%s%s',
            config('sanctum.token_prefix', ''),
            $tokenEntropy = Str::random(40),
            hash('crc32b', $tokenEntropy)
        );
        
        $hashedToken=hash('sha256', $plainTextToken);

        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $hashedToken),
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
        ]);
        

        return new NewAccessToken($token,$hashedToken);
    } 
}
