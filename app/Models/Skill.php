<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the contractors that have this skill.
     */
    public function contractors()
    {
        return $this->belongsToMany(Contractor::class, 'contractor_skills')
                    ->withTimestamps()
                    ->withPivot('years_experience', 'certification');
    }

    /**
     * Get the applications that require this skill.
     */
    public function applications()
    {
        return $this->belongsToMany(Application::class, 'application_skills')
                    ->withTimestamps();
    }

    /**
     * Get the projects that require this skill.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skills')
                    ->withTimestamps();
    }

    /**
     * Scope a query to only include active skills.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($skill) {
            if (empty($skill->slug)) {
                $skill->slug = str($skill->name)->slug();
            }
        });

        static::updating(function ($skill) {
            if ($skill->isDirty('name') && empty($skill->slug)) {
                $skill->slug = str($skill->name)->slug();
            }
        });
    }
}
