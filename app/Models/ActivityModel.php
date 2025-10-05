<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityModel extends Model
{
    use HasFactory;

    protected $table = 'activity_log';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'activity',
    ];

    protected $guarded = 'id';
}
