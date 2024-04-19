<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Filament\Panel;


class User extends Authenticatable implements FilamentUser
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'profileImage',
    ];


    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole("admin") && $this->email=="admin@admin.com";
    }

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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function points()
    {
        return $this->hasOne(Point::class, 'user_id');
    }

    public function ranks()
    {
        return $this->belongsToMany(Rank::class, 'rank_user');
    }

    public function trivias()
    {
        return $this->belongsToMany(Trivia::class, 'trivia_user')->withPivot("state");
    }

    public function publishedTrivias()
    {
        return $this->hasMany(PublishedTrivia::class, 'user_id');
    }

}
