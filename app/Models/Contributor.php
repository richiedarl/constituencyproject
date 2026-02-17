<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'email',
        'phone',
        'district',
        'gender',
        'bio',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function totalDonated(): float
    {
        return $this->donations()->sum('amount');
    }
}
