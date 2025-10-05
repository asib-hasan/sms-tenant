<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksModel extends Model
{
    use HasFactory;
    protected $table = 'marks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'std_reg_id',
        'class_id',
        'exam_id',
        'std_id',
        'student_id',
        'session_id',
        'subject_id',
        'roll_number',
        'mark',
        'grade_point',
        'letter_grade',
        'created_by',
        'updated_by',
    ];
    protected $guarded = [
        'id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
    public function exam_info()
    {
        return $this->belongsTo(ExamModel::class, 'exam_id', 'id');
    }

    public function class_info()
    {
        return $this->belongsTo(ClassModel::class, 'class_id' , 'id');
    }

    public function student_info()
    {
        return $this->belongsTo(Student::class,'student_id', 'id');
    }

    public function subject_info()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id', 'id');
    }

    public function session_info()
    {
        return $this->belongsTo(SessionModel::class, 'session_id' , 'id');
    }
}
