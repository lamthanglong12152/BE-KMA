<?php

namespace App\Http\Controllers\Admin\Classes;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class StudentController extends Controller
{
    public function addStudent(Request $request)
    {
        $code               = $request->has('st_code') ? $request->st_code : "";
        $class_name         = $request->has('st_class_name') ? $request->st_class_name : "";
        $class_code         = $request->has('st_class_code') ? $request->st_class_code : "";
        $num_of_sesssion    = $request->has('st_number_of_session') ? $request->st_number_of_session : 0;
        $studied            = $request->has('st_number_of_sessions_studied') ? $request->st_number_of_sessions_studied : 0;
        $fee                = $request->has('st_fee') ? $request->st_fee : 0;
        $fee_paid           = $request->has('st_fee_paid') ? $request->st_fee_paid : 0;
        $fee_remaining      = $request->has('st_fee_remaining') ? $request->st_fee_remaining : 0;
        $status_paid        = $request->has('st_status_paid') ? $request->st_status_paid : 0;

        if($studied >= $num_of_sesssion) { 
            return response()->json(['message'      => 'Bạn đã hoàn thành môn học này'], 500);
        }

        $insert = DB::table('students_in_class')->updateOrInsert(
            [
                'st_code'                           => $code,
                'st_class_name'                     => $class_name,
                'st_class_code'                     => $class_code
            ],
            [
                'st_code'                           => $code,
                'st_class_name'                     => $class_name,
                'st_class_code'                     => $class_code,
                'st_number_of_session'              => $num_of_sesssion,
                'st_number_of_sessions_studied'     => $studied,
                'st_fee'                            => $fee,
                'st_fee_paid'                       => $fee_paid,
                'st_fee_remaining'                  => $fee_remaining,
                'st_status_paid'                    => $status_paid
            ]
        );


        if ($insert) {
            return response()->json(['message'      => 'Thêm mới thành công']);
        } else {
            return response()->json(['message'      => 'Thêm mới thất bại'], 500);
        }
    }

    public function checkIn(Request $request){
        $dateCheckIn        = Carbon::now();
        $class_name         = $request->has('class_name') ? $request->class_name : ""; 
        $class_code         = $request->has('class_code') ? $request->class_code : "";
        $st_code            = $request->has('st_code')  ? $request->st_code : "";
        $status_check_in    = $request->has('status')   ? $request->status : 0;
        $teacher_id         = $request->has('teacher_id') ? $request->teacher_id : 0;
        $teacher_name       = $request->has('teacher_name') ? $request->teacher_name : "";
        $class_id           = $request->has('class_id') ? $request->class_id : 0;


        $insert = DB::table('student_check_in')->insert([
            'date_check_in'             => $dateCheckIn,
            'class_name'                => $class_name,
            'class_id'                  => $class_id,
            'class_code'                => $class_code,
            'code_student'              => $st_code,
            'status_check_in'           => $status_check_in,
            'teacher_check_in_id'       => $teacher_id,
            'teacher_check_in_name'     => $teacher_name
        ]); 


        if ($insert) {
            return response()->json(['message'      => 'Thêm mới thành công']);
        } else {
            return response()->json(['message'      => 'Thêm mới thất bại'], 500);
        }
    }
}
