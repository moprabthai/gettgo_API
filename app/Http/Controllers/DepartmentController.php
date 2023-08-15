<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $departments = DB::table('departments')->get();
        return $departments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // switch ($request->module) {
        //     case 'getall':
        //         $departments = DB::table('departments')->get();
        //         return $departments;
        //         break;
        //     case 'insert':
        //         DB::table('departments')->insert([
        //             'dep_code' => $request->dep_code,
        //             'dep_name' => $request->dep_name,
        //         ]);
        //         break;
        // }
        //
        switch ($request->module) {
            case 'getall':
                $departments = Department::get();
                return  DepartmentResource::collection($departments);
                break;
            case 'insert':
                // Created data
                try{
                    $departments = Department::create([
                        'dep_id' => $request->dep_id,
                        'dep_name' => $request->dep_name,
                    ]);
                    return response()->json(array(
                        'status'    =>  true,
                        'message'   =>  'สร้างสำเร็จ'
                    ));
                } catch (\Exception $e) {
                    return response()->json(array(
                        'status'    =>  false,
                        'message'   =>  $e
                    ));
                }

                break;
            case 'update':
                // Update data
                $departments = Department::where('dep_id', $request->dep_id)->update(array(
                    'dep_name' => $request->dep_name,
                ));
                return response()->json(array(
                    'status'    =>  true,
                    'message'   =>  'แก้ไขสำเร็จ'
                ));
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }
}
