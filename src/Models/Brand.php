<?php

namespace Lundash\SharedModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

	protected $table = 'brands';

    protected $fillable = [
        'name',
        'type',
        'enabled'
    ];

    public function brandUsersDetails(): HasMany
    {
        return $this->hasMany(BrandUserDetail::class);
    }

    public function themes(): HasMany
    {
        return $this->hasMany(BrandTheme::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user_brand');
    }

    public function cards(): HasManyThrough
    {
        return $this->hasManyThrough(BrandUserDetailCard::class, BrandUserDetail::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user_brand');
    }
}
