<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MisCostModel extends Model
{
    protected $table = 'mis_cost';

    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'ac_head_id',
        'amount',
        'receipt_no',
        'date',
        'note'
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

    #relations

    public function ac_head_info(){
        return $this->belongsTo(ACHeadModel::class,'ac_head_id','id');
    }
}
