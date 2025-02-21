<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'dni',
        'names',
        'paternal_surname',
        'maternal_surname',
        'email',
        'phone',
        'address',
        'birth_date',
        'department_id',
        'position_id',
    ];

    public $timestamps = false;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

}
