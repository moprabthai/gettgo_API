<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommandResource;
use App\Models\Command;
use App\Models\Employee;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        switch ($request->module) {
            case 'getall':
                $commands = Command::with('employee', 'employee.department')->Where('group_id', $request->group_id)->get();
                return  CommandResource::collection($commands);
                break;
            case 'getByEmp':
                $commands = Command::with('approver','approver.employee')->where('emp_id', $request->emp_id)->get();
                return  CommandResource::collection($commands);
                break;
            case 'insert':
                // Created data
                // return $request;
                try {
                    foreach ($request->data as $emp_id) {
                        Command::create([
                            'group_id' => $request->group_id,
                            'emp_id' => $emp_id,
                        ]);
                    }
                    return response()->json(array(
                        'status' => true,
                        'message' => 'สร้างสำเร็จ'
                    ));
                } catch (\Exception $e) {
                    return $e;
                }

                break;
            case 'delete_member':
                // Delete data
                foreach ($request->command_id as $command_id) {
                    Command::where('command_id', $command_id)->delete();
                }
                return response()->json(array(
                    'status'    =>  true,
                    'message'   =>  'ลบ!!'
                ));

                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Command $command)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function destroy(Command $command)
    {
        //
    }
}
