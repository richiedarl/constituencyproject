<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectPhase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'phase',           // planning | executing | documenting | completed
        'description',     // short desc
        'status',          // Ground tilled, foundation layed etc
        'started_at',
        'weight',
        'ended_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    /**
     * Relationships
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function media()
    {
        return $this->hasMany(ProjectMedia::class);
    }

    public function updates()
    {
        return $this->hasMany(Update::class);
    }

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($phase) {
            if (auth()->check()) {
                $phase->created_by = auth()->id();
            }
        });

        static::updating(function ($phase) {
            if (auth()->check()) {
                $phase->updated_by = auth()->id();
            }
        });
    }

    public function getBadgeClassAttribute(): string
{
    return match ($this->phase) {
        'executing'    => 'badge-info',
        'documenting' => 'badge-warning',
        default        => 'badge-secondary',
    };
}

}
