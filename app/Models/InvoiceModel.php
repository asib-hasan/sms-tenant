<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{

    protected $table = 'invoice';
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'id_number',
        'amount',
        'note',
        'payment_type',
        'month',
        'date',
        'session_id',
        'bank_account_no',
        'category_type',
        'created_by',
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    #Relation
    public function session_info(){
        return $this->belongsTo(SessionModel::class,'session_id','id');
    }
    ##Constant_Info
    #category_type(0) -> student
    #category_type(1) -> employee

}
