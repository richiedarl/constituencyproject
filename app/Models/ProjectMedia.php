<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_phase_id',
        'file_path',
        'file_type',       // image | video | document
    ];

    /**
     * Relationships
     */
    public function phase()
    {
        return $this->belongsTo(ProjectPhase::class, 'project_phase_id');
    }

    /**
     * Accessor for full URL (optional)
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
