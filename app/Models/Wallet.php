<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //
    protected $fillable = [
        'candidate_id',
        'balance',
        'currency'
    ];

    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }
}
