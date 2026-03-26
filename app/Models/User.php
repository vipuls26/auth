<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;
use App\Models\Blog;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]

class User extends Authenticatable implements MustVerifyEmail
{

    use Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // role
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')->withTimestamps();
    }

    // profile photo
    public function image(): HasOne
    {
        return $this->hasOne(ImageUpload::class,'user_id');
    }

    // blog post
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    // audit
    public function audit():HasMany
    {
        return $this->hasMany(AuditLog::class);
    }


}
