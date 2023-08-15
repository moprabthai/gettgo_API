<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApproverResource;
use App\Models\Approver;
use App\Models\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApproverController extends Controller
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
                $approvers = Approver::get();
                return  ApproverResource::collection($approvers);
                break;
            case 'insert':
                // Created data
                try {
                    $approvers = Approver::create([
                        'emp_id' => $request->emp_id,
                    ]);
                    return response()->json(array(
                        'status' => true,
                        'message'=>'สร้างสำเร็จ'
                    ));
                } catch (\Exception $e) {
                    return $e;
                }

                break;
            case 'update':
                // Update data
                $approvers = Approver::where('id', $request->emp_id)->update(array(
                    'emp_id' => $request->emp_id,
                ));
                return response()->json(array(
                    'status' => true,
                    'message'=>'แก้ไขสำเร็จ'));
                break;
            case 'delete':
                // Delete data
                $approvers = Approver::where('group_id', $request->group_id)->delete();
                $command = Command::where('group_id', $request->group_id)->delete();
                return response()->json(array(
                    'status'      =>  true,
                    'message'   =>  'ลบ!!'
                ));
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Approver  $approver
     * @return \Illuminate\Http\Response
     */
    public function show(Approver $approver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Approver  $approver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Approver $approver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Approver  $approver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approver $approver)
    {
        //
    }
}
