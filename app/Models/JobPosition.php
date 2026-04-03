<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    protected $fillable = ['title', 'description', 'department_id', 'status'];

    /**
     * Quan hệ: Một vị trí có thể có nhiều ứng viên
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'job_position_id');
    }
    public function department() {
    return $this->belongsTo(Department::class, 'department_id');
}
}
