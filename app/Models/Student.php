<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'college_register_no',
        'control_no',
        'registration_date',
        'course_id',
        'session_id',
        'name',
        'father_name',
        'mother_name',
        'gender',
        'religion',
        'category',
        'domicile_up',
        'is_handicap',
        'dob',
        'mobile',
        'address',
        'pincode',
        'photo_path',
        'signature_path',
    ];

    protected $casts = [
        'registration_date' => 'date',
        'dob' => 'date',
        'domicile_up' => 'boolean',
        'is_handicap' => 'boolean',
    ];

    /**
     * The "booted" method of the model.
     * Automatically cleans up stored photos and signatures when replaced or deleted.
     */
    protected static function booted(): void
    {
        // When updating, remove old photo/signature if replaced with a new file or cleared
        static::updating(function (Student $student) {
            if ($student->isDirty('photo_path')) {
                $oldPhoto = $student->getOriginal('photo_path');
                if (!empty($oldPhoto) && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldPhoto)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPhoto);
                }
            }

            if ($student->isDirty('signature_path')) {
                $oldSignature = $student->getOriginal('signature_path');
                if (!empty($oldSignature) && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldSignature)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldSignature);
                }
            }
        });

        // When deleting, remove associated photo and signature files from disk
        static::deleting(function (Student $student) {
            if (!empty($student->photo_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($student->photo_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($student->photo_path);
            }

            if (!empty($student->signature_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($student->signature_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($student->signature_path);
            }

            // Also clean up related qualifications
            $student->educationalQualifications()->delete();
        });
    }

    /**
     * Get the course that the student is enrolled in
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the session the student is registered in
     */
    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    /**
     * Get the educational qualifications for the student
     */
    public function educationalQualifications()
    {
        return $this->hasMany(EducationalQualification::class);
    }

    /**
     * Get the full file path for photo
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo_path ? asset('storage/' . $this->photo_path) : null;
    }

    /**
     * Get the full file path for signature
     */
    public function getSignatureUrlAttribute()
    {
        return $this->signature_path ? asset('storage/' . $this->signature_path) : null;
    }
}
