<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Fields allowed during CREATE & UPDATE
     */
    protected $fillable = [
        // Core
        'title',
        'slug',
        'description',
        'short_description',
        'type',
        'status',

        // Ownership / Scope
        'candidate_id',

        // Location
        'state',
        'lga',
        'ward',
        'community',
        'address',
        'latitude',
        'longitude',

        // Timeline & Cost
        'start_date',
        'completion_date',
        'estimated_budget',
        'actual_cost',

        // Media
        'featured_image',

        // Visibility
        'is_public',
        'is_active',

        // Audit
        'created_by',
        'updated_by',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'start_date'        => 'date',
        'completion_date'   => 'date',
        'estimated_budget'  => 'decimal:2',
        'actual_cost'       => 'decimal:2',
        'latitude'          => 'decimal:8',
        'longitude'         => 'decimal:8',
        'is_public'         => 'boolean',
        'is_active'         => 'boolean',
    ];

    /**
     * Boot logic
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }

            $originalSlug = $project->slug;
            $count = 1;

            while (static::where('slug', $project->slug)->exists()) {
                $project->slug = "{$originalSlug}-{$count}";
                $count++;
            }

            if (auth()->check()) {
                $project->created_by = auth()->id();
            }

            // Safe defaults
            $project->status ??= 'planning';
            $project->is_active ??= true;
            $project->is_public ??= true;
        });

        static::updating(function ($project) {
            if (auth()->check()) {
                $project->updated_by = auth()->id();
            }
        });
    }
/**
 * Get the current active phase of the project
 */
public function getCurrentPhaseAttribute()
{
    return $this->phases()
                ->whereNull('ended_at')
                ->latest('started_at')
                ->first();
}

/**
 * Get all completed (closed) phases
 */
public function getCompletedPhasesAttribute()
{
    return $this->phases()
                ->whereNotNull('ended_at')
                ->orderBy('started_at', 'asc')
                ->get();
}

/**
 * Get all phases ordered for timeline display
 */
public function getTimelinePhasesAttribute()
{
    return $this->phases()
                ->orderBy('started_at', 'asc')
                ->get();
}


    /**
     * Relationships
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function phases(){
        return $this->hasMany(ProjectPhase::class);
    }

    public function allMedia()
{
    return $this->hasManyThrough(
        ProjectMedia::class,
        ProjectPhase::class
    );
}


    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopePlanning($query)
    {
        return $query->where('status', 'planning');
    }

    /**
     * Accessors
     */
    public function getFullLocationAttribute()
    {
        return collect([
            $this->community,
            $this->ward ? "Ward: {$this->ward}" : null,
            $this->lga ? "LGA: {$this->lga}" : null,
            $this->state,
        ])->filter()->implode(', ');
    }

    public function getDurationAttribute()
    {
        if (!$this->start_date) {
            return null;
        }

        $start = Carbon::parse($this->start_date);
        $end = $this->completion_date
            ? Carbon::parse($this->completion_date)
            : now();

        return $start->diffForHumans($end, true);
    }

    /**
     * Helpers
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completion_date' => now(),
        ]);
    }

    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            'completed' => 'badge-success',
            'ongoing'   => 'badge-primary',
            'planning'  => 'badge-info',
            'cancelled' => 'badge-danger',
            default     => 'badge-secondary',
        };
    }
}
