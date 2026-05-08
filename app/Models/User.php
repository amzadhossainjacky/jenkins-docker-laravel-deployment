<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User model class
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'is_active',
        'gender',
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

    /**
     * Interact with user first_role
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function firstRole(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->getRoleNames()->first() ? $this->getRoleNames()->first() : 'undefined ';
            },
        );
    }

    /**
     * Interact with user first_role
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function routeSegment(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->getRoleNames()->count() ? $this->roles()->get()->pluck('route_segment')->toArray()[0] : 'admin';
            },
        );
    }
}
