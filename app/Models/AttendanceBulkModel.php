<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceBulkModel extends Model
{
    use HasFactory;
    protected $table = 'attendance_bulk';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'punch_id',
        'user_id',
        'user_type',
        'punch_time',
        'created_by',
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
