<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceModel extends Model
{
    use HasFactory;
    protected $table = 'attendance';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'user_type',
        'date',
        'check_in',
        'check_out',
        'updated_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $guarded = [
        'id',
    ];
}
