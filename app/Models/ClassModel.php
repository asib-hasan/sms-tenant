<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;
class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'class';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
    protected $guarded = [
        'id',
    ];


    #Queries

    static public function getClasses(){
        return Self::orderBy('code')->get();
    }

    static public function getName($id){
        return Self::where('id',$id)->value('name');
    }

    static public function getActiveClasses(){
        return Self::where('status', 0)->orderBy('code')->get();
    }

    static public function getSingle($id){
        return self::where('id',$id)->first();
    }

    static public function isDeletable($id)
    {
        if (Student::where('class_id', $id)->exists() || ClassSubjectModel::where('class_id', $id)->exists()) {
            return 0;
        } else {
            return 1;
        }
    }
}


