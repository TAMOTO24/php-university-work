<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'client_id',
        'trainer_id',
        'program_id',
        'appointment_date',
    ];
    

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function program()
    {
        return $this->belongsTo(TrainingProgram::class);
    }
}
