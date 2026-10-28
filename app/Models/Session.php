<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 'academic_sessions';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'remarks',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the students for the session
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
