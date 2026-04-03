<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'candidates';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'CV_path',
        'job_position_id',
        'status'
    ];

    protected $attributes = [
        'status' => 'applied',
    ];

    /*public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }*/
}
