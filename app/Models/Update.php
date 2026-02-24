<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    protected $fillable = [
        'phase_id',
        'project_id',
        'contractor_id',
        'report_date',
        'comment',
        'status',
        'approved_by',
        'approved_at',
        'admin_notes', // Add this if you're using it for rejection reasons
        'rejected_at',
        'rejected_by'
    ];

    protected $casts = [
        'report_date' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    public function phase()
    {
        return $this->belongsTo(ProjectPhase::class, 'phase_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function photos()
    {
        return $this->hasMany(ProjectMedia::class, 'update_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
