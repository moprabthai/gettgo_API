<?php

namespace App\Http\Controllers;
use App\Http\Resources\Shift_memberResource;
use App\Models\Shift_member;
use Illuminate\Http\Request;

class Shift_memberController extends Controller
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
                $shift_members = Shift_member::with('employee', 'employee.department')->Where('shift_id', $request->shift_id)->get();
                return  Shift_memberResource::collection($shift_members);
                break;
            case 'getByEmp':
                    $shift_members = Shift_member::where('emp_id',$request->emp_id)->get();
                    return  Shift_memberResource::collection($shift_members);
                    break;
            case 'insert':
                // Created data
                // return $request;
                try {
                    foreach ($request->data as $emp_id) {
                        Shift_member::create([
                            'shift_id'=>$request->shift_id,
                            'emp_id' => $emp_id,
                        ]);
                    }
                    return response()->json(array(
                        'status' => true,
                        'message' => 'สร้างสำเร็จ'
                    ));
                } catch (\Exception $e) {
                    return response(['status' => false, 'message' => $e->getMessage()]);
                }

                break;
            case 'delete_member':
                // Delete data
                foreach($request->shift_member_id as $shift_member_id){
                    Shift_member::where('shift_member_id', $shift_member_id)->delete();
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
     * @param  \App\Models\Shift_member  $shift_member
     * @return \Illuminate\Http\Response
     */
    public function show(Shift_member $shift_member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift_member  $shift_member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift_member $shift_member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift_member  $shift_member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift_member $shift_member)
    {
        //
    }
}
