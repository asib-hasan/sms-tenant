<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthsModel extends Model
{
    protected $table = 'month';
    use HasFactory;

    public static function getName($id){
        return Self::where('id',$id)->first()->name ?? '';
    }
}
