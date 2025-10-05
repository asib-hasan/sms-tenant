<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ACHeadModel extends Model
{
    protected $table = 'ac_head';
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'status',
        'category_type',
        'created_by',
        'updated_by'
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    //Relations ::::

    public function studentDues()
    {
        return $this->hasMany(StudentDuesModel::class, 'id');
    }

    public function employeeSalary()
    {
        return $this->hasMany(EmployeeSalaryModel::class, 'id');
    }

    //Queries:::::

    static public function getRecord(){
        $return = Self::get();
        return $return;
    }

    static public function getName($id){
        return Self::where('id', $id)->value('name') ?? '';
    }

    static public function getIncomeHead(){
        $return = Self::where('status', 0)->where('category_type',0)->get();
        return $return;
    }

    static public function getExpenseHead(){
        $return = Self::where('status', 0)->where('category_type',1)->get();
        return $return;
    }

    static public function getSingle($id){
        return self::where('id',$id)->first();
    }

    static public function isDeletable($id){
        if(StudentDuesModel::where('ac_head_id',$id)->exists()){
            return 0;
        }
        else if(EmployeeSalaryModel::where('ac_head_id',$id)->exists()){
            return 0;
        }
        else if(MisCostModel::where('ac_head_id',$id)->exists()){
            return 0;
        }
        else{
            return 1;
        }
    }

    ####Constants Information####

    #Category_type(0) = Income
    #Category_type(1) = Expense
}
