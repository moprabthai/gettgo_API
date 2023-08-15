<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShiftResource;
use App\Models\Shift;
use App\Models\Shift_member;
use Illuminate\Http\Request;

class ShiftController extends Controller
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
                $shifts = Shift::get();
                return  ShiftResource::collection($shifts);
                break;
            case 'insert':
                // Created data
                try {
                    $shifts = Shift::create([
                        'shift_name' => $request->shift_name,
                        'time_start' => $request->time_start,
                        'time_end' => $request->time_end,
                        'break' => $request->break,
                        'weekend' => $request->weekend,
                        'minus_hours'=> $request->minus_hours,
                        'cal_type'=>$request->cal_type,
                        'cal_price'=>$request->cal_price,
                        'cal_default'=>$request->cal_default
                    ]);
                    return response()->json(array(
                        'status' => true,
                        'message' => 'สร้างสำเร็จ'
                    ));
                } catch (\Exception $e) {
                    return response(['status' => false, 'message' => $e->getMessage()]);
                }
                break;
            case 'update':
                // Update data
                try {
                    $shifts = Shift::where('shift_id', $request->shift_id)->update(array(
                        'shift_name' => $request->shift_name,
                        'time_start' => $request->time_start,
                        'time_end' => $request->time_end,
                        'break' => $request->break,
                        'weekend' => $request->weekend,
                        'minus_hours'=> $request->minus_hours,
                        'cal_type'=>$request->cal_type,
                        'cal_price'=>$request->cal_price,
                        'cal_default'=>$request->cal_default
                    ));
                    return response()->json(array(
                        'status' => true,
                        'message' => 'แก้ไขสำเร็จ'
                    ));
                } catch (\Exception $e) {
                    return response(['status' => false, 'message' => $e->getMessage()]);
                }
                break;
                case 'delete':
                    // Delete data
                    $shifts = Shift::where('shift_id', $request->shift_id)->delete();
                    $shift_member = Shift_member::where('shift_id', $request->shift_id)->delete();
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
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        //
    }
}
