<?php
namespace App\Helpers;

use App\Models\ActivityModel;
use App\Models\EmployeeSalaryModel;
use App\Models\MarksModel;
use App\Models\StudentDuesModel;
use App\Models\GradeModel;
use App\Models\InvoiceModel;
use App\Models\StudentRegistrationModel;
use Illuminate\Support\Facades\Log;

class Helper
{
        protected $user;

        public function __construct($user)
        {
            $this->user = $user;
        }
        public static function encrypt_decrypt($action, $string) {
            $output = false;
            $encrypt_method = 'AES-128-CBC';
            $secret_key = 'okzHbztRQNnWVMCd4XRdtVkKR';
            $secret_iv = '12345678901122';
            $key = hash('sha256', $secret_key);
            $iv = substr(hash('sha256', $secret_iv), 0, 16); // AES block size in CBC mode is 16 bytes regardless of key size.

            if ($action == 'encrypt') {
                $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
                $output = base64_encode($output);
            } elseif ($action == 'decrypt') {
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            }

            return $output;
        }

        public static function generateInvoiceNumber() {
            do {
                $year = now()->format('y');
                $timestamp = now()->format('His');
                $timestamp = substr($timestamp, -4);

                $randomNumber = mt_rand(1000, 9999);

                $invoice_no = $year . $timestamp . $randomNumber;

                # Check if this invoice number already exists
                $invoiceExists = InvoiceModel::where('invoice_no', $invoice_no)->exists();
            } while ($invoiceExists); # Regenerate if a duplicate is found

            return $invoice_no;
        }

        public static function generateRegistrationNumber($prefix = 'MH') {
            $dateTime = date('ymd');
            $count_with_prefix = StudentRegistrationModel::where('reg_no', 'LIKE', $prefix . $dateTime . '%')->count();
            $zero = '';
            if($count_with_prefix < 9)$zero = '00';
            else if($count_with_prefix < 99)$zero = '0';
            $dateTime = $prefix . $dateTime . $zero . ($count_with_prefix+1);
            return $dateTime;
        }

        public static function numberToWords($number) {
           $words = [
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety',
        ];

        // Fill the array with words for numbers from one to ninety-nine
        for ($i = 21; $i <= 99; $i++) {
            if (!isset($words[$i])) {
                $tens = floor($i / 10) * 10;
                $units = $i % 10;
                $words[$i] = $words[$tens] . '-' . $words[$units];
            }
        }
        $result = '';

        if ($number == 0) {
            return $words[0];
        }

        // Convert crores
        $crores = floor($number / 10000000);
        if ($crores > 0) {
            $result .= Helper::numberToWords($crores) . ' Crore ';
            $number %= 10000000;
        }

        // Convert lacs
        $lacs = floor($number / 100000);
        if ($lacs > 0) {
            $result .= $words[$lacs] . ' Lacs ';
            $number %= 100000;
        }

        // Convert thousands
        $thousands = floor($number / 1000);
        if ($thousands > 0) {
            $result .= Helper::numberToWords($thousands) . ' Thousand ';
            $number %= 1000;
        }

        // Convert hundreds
        $hundreds = floor($number / 100);
        if ($hundreds > 0) {
            $result .= $words[$hundreds] . ' Hundred ';
            $number %= 100;
        }

        // Convert tens and ones
        if ($number > 0) {
            if ($number < 20) {
                $result .= $words[$number];
            } else {
                $result .= $words[floor($number / 10) * 10];
                $number %= 10;
                if ($number > 0) {
                    $result .= ' ' . $words[$number];
                }
            }
        }
        return rtrim($result);
    }

    public static function sms_send($message, $number) {
        return (['response_code' => 202]);
        $url = "http://bulksmsbd.net/api/smsapi";
        $api_key = "rOh1UZ3SmpPXVkpT3G6x";
        $senderid = "8809617615123";
        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
    public static function findFeesByStudent($month,$session_id,$student_id){
        $Fees = StudentDuesModel::where('month',$month)->where('student_id',$student_id)->where('session_id',$session_id)->get();
        return $Fees;
    }

    public static function findFeesByClassMonth($month,$session_id,$class_id){
        $students = StudentRegistrationModel::where('session_id',$session_id)->where('class_id',$class_id)->get();
        $student_ids = $students->pluck('student_id')->toArray();

        $fees_list = StudentDuesModel::whereIn('student_id',$student_ids)->where('session_id',$session_id)->where('month',$month)->get();
        return $fees_list;
    }
    public static function findFeesReport($month,$session){
        $Fees = StudentDuesModel::where('month',$month)->where('session_id',$session)->get();
        return $Fees;
    }

    public static function findSalaryByEmployee($month,$session_id,$employee_id){
        $Salary = EmployeeSalaryModel::where('month',$month)->where('emp_user_id',$employee_id)->where('session_id',$session_id)->get();
        return $Salary;
    }
    public static function findSalaryByDesignationMonth($month,$session,$designation){
        $Salary = EmployeeSalaryModel::where('month',$month)->where('designation_id',$designation)->where('session_id',$session)->get();
        return $Salary;
    }


    public static function findSalaryReport($month,$session_id){
        $Fees = EmployeeSalaryModel::where('month',$month)->where('session_id',$session_id)->get();
        return $Fees;
    }

    public static function getResult($student_id, $class_id, $subject_id,$session_id, $exam_id){
        $data = MarksModel::where('student_id',$student_id)
                          ->where('class_id',$class_id)
                          ->where('subject_id',$subject_id)
                          ->where('session_id',$session_id)
                          ->where('exam_id',$exam_id)
                          ->first();
        return $data;
    }

    public static function find_grade_from_point($point)
    {
        $letter = 'NA';
        $grades = config('grades');

        foreach ($grades as $grade) {
            if ($point >= $grade['point']) {
                $letter = $grade['letter_grade'];
                break;
            }
        }

        return $letter;
    }




    public static function canAny($user, $arguments = [])
    {
        foreach ($arguments as $permissionId) {
            if($user->hasPermission($user->id,$permissionId)) return true;
        }
        return false;
    }


    public static function store_activity($user_id,$activity)
    {
        try{
            ActivityModel::create([
                'user_id' => $user_id,
                'activity' => $activity,
            ]);
        }
        catch(\Exception $e){
            Log::error('Failed to store acticity - ' . $e->getMessage());
        }
    }
}
