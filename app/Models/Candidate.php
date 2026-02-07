<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'email',
        'phone',
        'district',
        'gender',
        'bio',
        'photo',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(CandidatePosition::class);
    }

    public function currentPosition()
    {
        return $this->hasOne(CandidatePosition::class)
                    ->where('is_current', true);
    }
}
