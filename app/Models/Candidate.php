<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'candidates';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'cv_path',
        'job_position_id',
        'status'
    ];

    protected $attributes = [
        'status' => 'applied',
    ];

    protected $casts = [
        'status' => \App\Enums\CandidateStatus::class,
    ];

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }
}
