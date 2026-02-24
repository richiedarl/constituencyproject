<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportKey extends Model
{
    protected $fillable = [
        'candidate_id',
        'key',
        'expires_at',
        'is_used',
        'used_at',
        'used_by_ip',
        'used_by_user_agent',
        'created_by'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
