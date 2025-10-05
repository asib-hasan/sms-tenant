<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestModel extends Model
{
    protected $table = 'donation_income';
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'type',
        'amount',
        'receipt_no',
        'date',
        'note',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    protected $guarded = [
        'id'
    ];

    #Constant
    # 0 -> Individual
    # 1 -> Organization

}
