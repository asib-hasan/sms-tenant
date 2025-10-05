<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassTeacherModel extends Model
{
    use HasFactory;
    protected $table = 'class_teacher';
    protected $primaryKey = 'id';

    protected $fillable = [
        'class_id',
        'teacher_id',
        'session_id',
        'updated_by',
    ];

    protected $hidden = [
        'updated_by',
        'created_by',
        'created_at',
        'updated_at'
    ];
    protected $guarded = [
        'id',
    ];

    public function class_info(){
        return $this->belongsTo(ClassModel::class, 'class_id', 'id');
    }
    public function session_info(){
        return $this->belongsTo(SessionModel::class, 'session_id', 'id');
    }
}
