<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\CandidatePosition;

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
        'approved',
        'gender',
        'bio',
        'photo',
    ];

    protected $casts = [
        'paid' => 'boolean',
        'approved' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($candidate) {
            // Generate slug if not provided
            if (empty($candidate->slug)) {
                $candidate->slug = Str::slug($candidate->name);
            }

            // Set approval status based on who is creating the candidate
            if (auth()->check()) {
                // If admin is creating, auto-approve
                if (auth()->user()->admin) {
                    $candidate->approved = true;
                }
                // If not set explicitly and not admin, default to unapproved
                elseif (!isset($candidate->approved)) {
                    $candidate->approved = false;
                }
            }
            // For CLI/seeders or when no auth, you might want to set a default
            elseif (!isset($candidate->approved)) {
                $candidate->approved = false; // Default to unapproved for safety
            }
        });

        // You might also want to handle updates
        static::updating(function ($candidate) {
            // Prevent non-admins from approving themselves
            if (auth()->check() && !auth()->user()->admin) {
                // If trying to change approval status, revert to original
                if ($candidate->isDirty('approved')) {
                    $candidate->approved = $candidate->getOriginal('approved');
                }
            }
        });
    }

    // Scopes for easy filtering
    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('approved', false);
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(CandidatePosition::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    // Helper methods
    public function isApproved(): bool
    {
        return $this->approved;
    }

    public function approve(): bool
    {
        return $this->update(['approved' => true]);
    }

    public function disapprove(): bool
    {
        return $this->update(['approved' => false]);
    }
}
