<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'qualification_type',
        'board_university',
        'stream',
        'year_of_completion',
        'roll_number',
        'max_marks',
        'obtained_marks',
        'percentage',
    ];

    protected $casts = [
        'year_of_completion' => 'integer',
        'max_marks' => 'integer',
        'obtained_marks' => 'integer',
        'percentage' => 'decimal:2',
    ];

    /**
     * Get the student that owns this qualification
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
