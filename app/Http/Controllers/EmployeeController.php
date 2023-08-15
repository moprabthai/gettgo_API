<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Approver;
use App\Models\Command;
use App\Models\Shift_member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // switch ($request->mo) {
        //     case 'getall':
        //         $employees = DB::table('employees')->leftjoin('departments','employees.dep_id','departments.dep_id')
        //         ->select('*')->get();
        //         return $employees;

        //         break;
        //     case 'getby':
        //         $employees = Employee::where("fname",$request->fname)->get();
        //         return response()->json(['Successfully',EmployeeResource::collection($employees)]);
        //         break;
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        switch ($request->module) {
            case 'getall':
                $employees = Employee::Where('dep_id', 'like', '%' . $request->dep_search . '%')
                    ->where(function ($query) use ($request) {
                        $query->where('emp_id', 'like', '%' . $request->textsearch . '%')
                            ->orWhere('fname', 'like', '%' . $request->textsearch . '%')
                            ->orWhere('lname', 'like', '%' . $request->textsearch . '%');
                    })->get();
                return  EmployeeResource::collection($employees);
                break;
            case 'getadmin':
                $employees = Employee::Where('isadmin', 1)->get();
                return EmployeeResource::collection($employees);
                break;
            case 'get_employee_none_sup':
                $approvers = Approver::get();
                $stack = array();
                // Loop add emp -> approver
                foreach ($approvers as $i) {
                    array_push($stack, $i->emp_id);
                }
                // get emp unless aprrover
                $employees = Employee::Where('dep_id', 'like', '%' . $request->dep_search . '%')
                    ->where(function ($query) use ($request) {
                        $query->where('emp_id', 'like', '%' . $request->textsearch . '%')
                            ->orWhere('fname', 'like', '%' . $request->textsearch . '%')
                            ->orWhere('lname', 'like', '%' . $request->textsearch . '%');
                    })->whereNotIn('emp_id', $stack)->get();
                return  EmployeeResource::collection($employees);
                break;
            case 'get_employee_none_group':
                $commands = Command::get();
                $stack = array();
                // Loop add emp -> group
                array_push($stack, $request->sup_id);
                foreach ($commands as $i) {
                    array_push($stack, $i->emp_id);
                }
                // get emp unless group
                $employees = Employee::Where('dep_id', 'like', '%' . $request->dep_search . '%')
                    ->where(function ($query) use ($request) {
                        $query->where('emp_id', 'like', '%' . $request->textsearch . '%')
                            ->orWhere('fname', 'like', '%' . $request->textsearch . '%')
                            ->orWhere('lname', 'like', '%' . $request->textsearch . '%');
                    })->whereNotIn('emp_id', $stack)->get();
                return  EmployeeResource::collection($employees);
                break;
            case 'get_employee_none_shift':
                $shift_members = Shift_member::get();
                $stack = array();
                // Loop add emp -> shift_member
                foreach ($shift_members as $i) {
                    array_push($stack, $i->emp_id);
                }
                // get emp unless shift_member
                $employees = Employee::Where('dep_id', 'like', '%' . $request->dep_search . '%')
                    ->where(function ($query) use ($request) {
                        $query->where('emp_id', 'like', '%' . $request->textsearch . '%')
                            ->orWhere('fname', 'like', '%' . $request->textsearch . '%')
                            ->orWhere('lname', 'like', '%' . $request->textsearch . '%');
                    })->whereNotIn('emp_id', $stack)->get();
                return  EmployeeResource::collection($employees);
                break;
            case 'insert':
                // Created data
                try {
                    $employees = Employee::create([
                        'emp_id' => $request->emp_id,
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'dep_id' => $request->dep_id,
                        'salary' => $request->salary,
                        'email' => $request->email,
                        'password' => $request->password,
                        'isadmin' => $request->isadmin,
                        'active' => $request->active
                    ]);
                    return response()->json(array(
                        'status'    =>  true,
                        'message'   =>  'สร้างสำเร็จ'
                    ));
                } catch (\Exception $e) {
                    return response()->json(array(
                        'status'    =>  false,
                        'message'   =>  'รหัสพนักงานซ้ำ'
                    ));
                }

                break;
            case 'update':
                $admin = Employee::Where('isadmin', 1)->get();
                if (count($admin) == 1 && $request->isadmin == 0&&$admin[0]->emp_id==$request->emp_id) {
                    //Check Admin
                    return response()->json(array(
                        'status'    =>  false,
                        'message'   =>  'ต้องมี Admin อย่างน้อย 1 คน'
                    ));
                } else {
                    // Update data
                    $employees = Employee::where('emp_id', $request->emp_id)->update(array(
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'dep_id' => $request->dep_id,
                        'salary' => $request->salary,
                        'email' => $request->email,
                        'isadmin' => $request->isadmin,
                        'active' => $request->active
                    ));
                    return response()->json(array(
                        'status'    =>  true,
                        'message'   =>  'แก้ไขสำเร็จ'
                    ));
                }



                break;
            case 'login':
                $email = Employee::where('email', $request->email)->get();
                $password = Employee::where('email', $request->email)->where('password', $request->password)->get();

                $email_true = false;
                $pass_true = false;

                if (count($email) != 0) {
                    $email_true = true;
                }
                if (count($password) != 0) {
                    $pass_true = true;
                }

                return response()->json(array(
                    'email' => $email_true,
                    'password' => $pass_true,
                    'data'    => EmployeeResource::collection($password),
                ));

                break;
            case 'default_password':
                $employees = Employee::where('emp_id', $request->emp_id)->update(array(
                    'password' => $request->password,
                ));
                return response()->json(array(
                    'status'    =>  true,
                    'message'   =>  'เปลี่ยนเป็นรหัสผ่านเริ่มต้นแล้ว'
                ));
                break;
            case 'change_password':
                $password = Employee::where('emp_id', $request->emp_id)->where('password', $request->old_pass)->get();
                if (count($password) != 0) {
                    $pass_true = true;
                    $employees = Employee::where('emp_id', $request->emp_id)->update(array(
                        'password' => $request->new_pass,
                    ));
                    return response()->json(array(
                        'status'    =>  true,
                        'message'   =>  'เปลี่ยนเป็นรหัสผ่านสำเร็จ'
                    ));
                } else {
                    $pass_true = false;
                    return response()->json(array(
                        'status'    =>  false,
                        'message'   =>  'รหัสผ่านเดิมไม่ถูกต้อง'
                    ));
                }


                break;



                // case 'get':
                //     $employees = DB::table('employees')->select('*')->get();
                //     foreach ($employees as $dep){
                //         $dep->dep = DB::table('departments')->where("dep_id", $dep->dep_id)->get();
                //     }
                //     return $employees;
                //     break;
        }


        // Check validator
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'fname' => 'required|string',
        //         'lname' => 'required|string',
        //         'salary' => 'required|numeric',
        //     ]
        // );

        // If validator fails
        // if ($validator->fails()) {
        //     //return message
        //     return response()->json($validator->errors());
        // }

        //Created data
        // $emplopyee = Employee::create([
        //     'fname' => $request->fname,
        //     'lname' => $request->lname,
        //     'salary' => $request->salary,

        // ]);

        // Return message and data
        // return response()->json(['Create Success', new EmployeeResource($emplopyee)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
