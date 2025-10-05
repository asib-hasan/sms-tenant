<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeStudentDuesModel extends Model
{
    use HasFactory;
    protected $table = 'income_student_dues';

    protected $fillable = [
        'dues_id',
        'amount',
        'student_id',
        'std_id',
        'month',
        'session_id',
        'date',
        'ac_head_id',
        'invoice_id',
        'created_by'
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    #Relations
    public function student_dues()
    {
        return $this->belongsTo(StudentDuesModel::class, 'dues_id' , 'id');
    }
    public function invoice_info()
    {
        return $this->belongsTo(InvoiceModel::class, 'invoice_id','id');
    }
    public function ac_head_info()
    {
        return $this->belongsTo(ACHeadModel::class, 'ac_head_id','id');
    }
}
