<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = ['name', 'subject', 'email', 'content', 'is_read'];
}
