<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_phase_id',
        'update_id',
        'file_path',
        'file_type',
        'uploaded_by'
    ];

    /**
     * Relationships
     */
    public function phase()
    {
        return $this->belongsTo(ProjectPhase::class, 'project_phase_id');
    }

    public function updateRecord() // Changed from 'update' to 'updateRecord'
    {
        return $this->belongsTo(Update::class, 'update_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Accessor for full URL
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
