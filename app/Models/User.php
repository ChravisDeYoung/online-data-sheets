<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone_number
 * @property string $password
 * @property string $remember_token
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> $fillable
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string> $hidden
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string> $casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #region Accessors

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    #endregion

    #region Mutators
    /**
     * Set the user's password.
     *
     * @param $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    #endregion

    #region Query Scopes
    /**
     * Search for users.
     *
     * @param $query
     * @param $search
     * @return void
     */
    public function scopeSearch($query, $search)
    {
        $query->when($search, function () use ($query, $search) {
            return $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        });
    }
    #endregion

    #region Relationships
    /**
     * Get the roles.
     *
     * @return BelongsToMany The roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
    #endregion
}
