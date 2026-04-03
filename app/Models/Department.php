<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'manager_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the manager of this department.
     */
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * Get all employees in this department.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
