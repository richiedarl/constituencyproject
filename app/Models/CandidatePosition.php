<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidatePosition extends Model
{
    protected $fillable = [
        'candidate_id',
        'position',
        'year_from',
        'year_until',
        'is_current',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }
}
