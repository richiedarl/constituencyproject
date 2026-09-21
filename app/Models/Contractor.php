<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'company_name',
        'email',
        'phone',
        'approved',
        'district',
        'gender',
        'occupation', // e.g., "skilled worker"
        'experience_years',
        'verified',
        'verified_at',
        'verified_by',
        'suspended',
        'suspended_at',
        'suspended_by',
        'suspension_reason',
        'bio',
        'photo',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'verified' => 'boolean',
        'verified_at' => 'datetime',
        'suspended' => 'boolean',
        'suspended_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   public function applications()
{
    return $this->hasMany(Application::class);
}
public function projects()
{
    return $this->belongsToMany(Project::class, 'applications')
        ->withPivot('status', 'approved_at', 'approved_by')
        ->withTimestamps();
}



public function pendingApplications()
{
    return $this->hasMany(Application::class)->where('status', 'pending');
}

public function approvedApplications()
{
    return $this->hasMany(Application::class)->where('status', 'approved');
}

    // In Contractor.php
public function skills()
{
    return $this->belongsToMany(Skill::class, 'contractor_skills')
                ->withTimestamps()
                ->withPivot('years_experience', 'certification');
}

public function getApprovedProjectsCountAttribute()
{
    return $this->attributes['projects_count']
        ?? $this->applications()
            ->where('status', Application::STATUS_APPROVED)
            ->count();
}

}
