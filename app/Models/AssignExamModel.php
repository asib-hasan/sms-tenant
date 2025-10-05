<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignExamModel extends Model
{
    use HasFactory;

    protected $table = 'assign_exam';
    protected $primaryKey = 'id';
    protected $guarded = 'id';

    protected $hidden = [
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function exam_info(){
        return $this->belongsTo(ExamModel::class, 'exam_id', 'id');
    }
    public function class_info(){
        return $this->belongsTo(ClassModel::class, 'class_id', 'id');
    }
    public function session_info(){
        return $this->belongsTo(SessionModel::class, 'session_id', 'id');
    }
}
