<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'first_name',
        'last_name',
        'specialization',
    ];

    public function index()
    {
        $trainers = Trainer::all();

        return view('trainers.index', compact('trainers'));
    }
}
