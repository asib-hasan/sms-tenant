<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleUserModel extends Model
{
    protected $table = 'module_user';
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'user_id',
        'module_id',
    ];

    public function modules(){
        return $this->belongsTo(ModuleModel::class,'module_id');
    }

    public function users(){
        return $this->belongsToMany(ModuleUserModel::class,'module_user','id','user_id');
    }
}
