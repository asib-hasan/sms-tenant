<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekDaysModel extends Model
{
    use HasFactory;

    protected $table = 'week_days';

    protected $fillable = [
        'name',
        'is_active',
        'updated_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
    ];
}
