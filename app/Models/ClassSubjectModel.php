<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;
class ClassSubjectModel extends Model
{
    use HasFactory;

    protected $table = 'class_subject';


    protected $fillable = [
        'class_id',
        'subject_id',
        'session_id',
        'created_by',
    ];
    static public function getSingle($id){
        return self::where('id',$id)->first();
    }
    static public function getAlreadyfirst($class_id, $subject_id){
        return self::where('class_id','=',$class_id)->where('subject_id','=',$subject_id)->first();
    }

    static public function getAssignSubjectID($class_id){
        return self::where('class_id','=',$class_id)
                    ->get();
    }

    #Relations

    public function subject_info()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id','id');
    }
    public function class_info()
    {
        return $this->belongsTo(ClassModel::class, 'class_id','id');
    }
    public function session_info(){
        return $this->belongsTo(SessionModel::class, 'session_id','id');
    }
}
