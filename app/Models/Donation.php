<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'contributor_id',
        'project_id',
        'amount'
    ];

    public function contributor()
    {
        return $this->belongsTo(Contributor::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
