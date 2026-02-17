<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function skills()
    {
        return $this->hasMany(Skill::class, 'category', 'slug');
    }
}
