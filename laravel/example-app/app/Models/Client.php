<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'membership_type',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
