<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Candidate extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'email',
        'paid',
        'phone',
        'district',
        'state',
        'gender',
        'bio',
        'photo',
    ];

    protected $casts = [
        'paid' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($candidate) {
            if (empty($candidate->slug)) {
                $candidate->slug = Str::slug($candidate->name);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
