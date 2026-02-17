<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPLIED = 'applied';
    const STATUS_APPROVED = 'approved';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REJECTED = 'rejected';
    const STATUS_WITHDRAWN = 'withdrawn';

    protected $fillable = [
        'candidate_id',
        'contributor_id',
        'project_id',
        'contractor_id',
        'status',
        'approved_at',
        'approved_by',
        'cancelled_at',
        'cancelled_by',
        'cancellation_reason'
    ];

    // Relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class);
    }

    public function contributor(): BelongsTo
    {
        return $this->belongsTo(Contributor::class);
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    // Status checks
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApplied(): bool
    {
        return $this->status === self::STATUS_APPLIED;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function canBeCancelled(): bool
    {
        return $this->isPending() || $this->isApplied();
    }
}
