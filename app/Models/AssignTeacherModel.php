<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignTeacherModel extends Model
{
    use HasFactory;
    protected $table = 'assign_teacher';
    protected $primaryKey = 'id';

    protected $fillable = [
        'teacher_id_primary',
        'teacher_user_id',
        'class_id',
        'exam_id',
        'session_id',
        'subject_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $guarded = 'id';

    #Relations
    public function subject_info()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id','id');
    }

    public function employee_info()
    {
        return $this->belongsTo(TeacherModel::class,'teacher_id_primary','id');
    }
    public function exam_info(){
        return $this->belongsTo(ExamModel::class,'exam_id','id');
    }

    public function class_info(){
        return $this->belongsTo(ClassModel::class,'class_id','id');
    }
    public function session_info(){
        return $this->belongsTo(SessionModel::class,'session_id','id');
    }
}
