<?php

namespace App\Http\Controllers;



use App\Http\Resources\Request_otResource;
use App\Models\Request_ot_Detail;
use App\Models\Request_ot;
use App\Models\History;
use App\Models\Employee;
use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;


class Request_otController extends Controller
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
        function insertDetail($id, $row)
        {
            Request_ot_Detail::where('request_ot_id', $id)->delete();
            foreach ($row as $item) {
                Request_ot_Detail::insert([
                    'request_ot_id' => $id,
                    'no' => $item['no'],
                    'time_start' => ($item['time_start'] != "") ? Carbon::createFromFormat('d-m-Y H:i', $item['time_start']) : null,
                    'time_end' => ($item['time_end'] != "") ? Carbon::createFromFormat('d-m-Y H:i', $item['time_end']) : null,
                    'type' => $item['type'],
                    'price_of_hours' => $item['price_of_hours'],
                    'total_hours' => $item['total_hours'],
                    'total_price' => $item['total_price'],
                    'note' => $item['note'],
                    'comment' => $item['comment'],
                ]);
            }
        }
        //
        function insertHistory($id, $name, $status, $comment)
        {
            History::create([
                'request_ot_id' => $id,
                'action_by' => $name,
                'requestStatus' => $status,
                'comment' => $comment
            ]);
        }
        //
        function SentEmail($assignTo, $requestno, $requeststatus, $comment)
        {
            //getMail
            $employee = Employee::where('emp_id', $assignTo)->get();
            $email =  $employee[0]->email;
            $fullname = $employee[0]->fname . " " . $employee[0]->lname;
            Mail::to($email)->send(new NotificationMail([
                'assignTo' => $fullname,
                'requestno' => $requestno,
                'requeststatus' => $requeststatus,
                'comment' => $comment
            ]));
        }
        //
        function generatePDF($id)
        {
            $head = Request_ot::where('id', $id)->get();
            $detail = Request_ot_Detail::where('request_ot_id', $id)->get();
            $pdf = PDF::loadView('pdf', [
                'head' => $head,
                'detail' => $detail
            ]);

            $base64Pdf = base64_encode($pdf->output([], 'S'));

            return $base64Pdf;
        }

        switch ($request->module) {
            case 'Savedraft':
                if ($request->id == null) {
                    $requestOT = Request_ot::insertGetId([
                        //from Back
                        'requestStatus_No' => 0,
                        'requestStatus' => 'บันทึกร่าง',

                        //from Font
                        'requestDate' => Carbon::createFromFormat('d/m/Y', $request->body['header']['requestDate'])->format('Y-m-d'),
                        'employeeID' => $request->body['header']['employeeID'],
                        'employeeName' => $request->body['header']['employeeName'],
                        'approverID' => $request->body['header']['approverID'],
                        'department' => $request->body['header']['department'],
                        'approverName' => $request->body['header']['approverName'],
                        'salary' => $request->body['header']['salary'],
                        'shift' => $request->body['header']['shift'],
                        'shiftTime' => $request->body['header']['shiftTime'],
                        'shiftBreak' => $request->body['header']['shiftBreak'],
                        'shiftWeekend' => $request->body['header']['shiftWeekend'],
                        'shiftMinus_hours' => $request->body['header']['shiftMinus_hours'],
                        'price_of_hours' => $request->body['header']['price_of_hours'],
                        'totalprice_ot' => $request->body['total']['price'],
                        'assignTo' => $request->body['header']['employeeID'],
                        'assignTo_name' => $request->body['header']['employeeName'],
                        // 'comment'=>$request->comment
                    ]);
                    insertDetail($requestOT, $request->body['detail']);

                    return response()->json(array(
                        'status' => true,
                        'Request_id' => $requestOT
                    ));
                } else if ($request->id != null) {
                    $requestOT = Request_ot::where('id', $request->id)->update([
                        //from Back
                        'requestStatus_No' => 0,
                        'requestStatus' => 'บันทึกร่าง',
                        //from Font
                        'requestDate' => Carbon::createFromFormat('d/m/Y', $request->body['header']['requestDate'])->format('Y-m-d'),
                        'employeeID' => $request->body['header']['employeeID'],
                        'employeeName' => $request->body['header']['employeeName'],
                        'department' => $request->body['header']['department'],
                        'approverID' => $request->body['header']['approverID'],
                        'approverName' => $request->body['header']['approverName'],
                        'salary' => $request->body['header']['salary'],
                        'shift' => $request->body['header']['shift'],
                        'shiftTime' => $request->body['header']['shiftTime'],
                        'shiftBreak' => $request->body['header']['shiftBreak'],
                        'shiftWeekend' => $request->body['header']['shiftWeekend'],
                        'shiftMinus_hours' => $request->body['header']['shiftMinus_hours'],
                        'price_of_hours' => $request->body['header']['price_of_hours'],
                        'totalprice_ot' => $request->body['total']['price'],
                        'assignTo' => $request->body['header']['employeeID'],
                        'assignTo_name' => $request->body['header']['employeeName'],
                        // 'comment'=>$request->comment
                    ]);
                    insertDetail($request->id, $request->body['detail']);
                    return response()->json(array(
                        'status' => true,
                        'Request_id' => $request->id
                    ));
                }
                break;
            case 'Submit':
                function CreateRequestNo($date)
                {
                    $monthRequest = Carbon::createFromFormat('d/m/Y', $date)->format('m');
                    $YearRequest = Carbon::createFromFormat('d/m/Y', $date)->format('Y');
                    $YearRequest_y = Carbon::createFromFormat('d/m/Y', $date)->format('y');
                    $getRequestOT = Request_ot::whereMonth('created_at', $monthRequest)->whereYear('created_at', $YearRequest)
                        ->Where('requestStatus_No', '!=', 0)->get();
                    $requestNo = 'REQ' . $YearRequest_y . $monthRequest . sprintf('%03d', count($getRequestOT) + 1);
                    return  $requestNo;
                }
                $requestNo = ($request->body['header']['requestNo'] == null) ? CreateRequestNo($request->body['header']['requestDate']) : $request->body['header']['requestNo'];
                if ($request->id == null) {
                    $requestOT = Request_ot::insertGetId([
                        //from Back
                        // 'requestNo' => CreateRequestNo($request->body['header']['requestDate']),
                        'requestNo' => $requestNo,
                        'requestStatus_No' => 1,
                        'requestStatus' => 'รอการอนุมัติจากผู้บังคับบัญชา',
                        //from Font
                        'requestDate' => Carbon::createFromFormat('d/m/Y', $request->body['header']['requestDate'])->format('Y-m-d'),
                        'employeeID' => $request->body['header']['employeeID'],
                        'employeeName' => $request->body['header']['employeeName'],
                        'department' => $request->body['header']['department'],
                        'approverID' => $request->body['header']['approverID'],
                        'approverName' => $request->body['header']['approverName'],
                        'salary' => $request->body['header']['salary'],
                        'shift' => $request->body['header']['shift'],
                        'shiftTime' => $request->body['header']['shiftTime'],
                        'shiftBreak' => $request->body['header']['shiftBreak'],
                        'shiftWeekend' => $request->body['header']['shiftWeekend'],
                        'shiftMinus_hours' => $request->body['header']['shiftMinus_hours'],
                        'price_of_hours' => $request->body['header']['price_of_hours'],
                        'totalprice_ot' => $request->body['total']['price'],
                        'assignTo' => $request->body['header']['approverID'],
                        'assignTo_name' => $request->body['header']['approverName'],

                    ]);
                    insertDetail($requestOT, $request->body['detail']);
                    insertHistory($requestOT, $request->action_by, 'ส่งโดยผู้ร้องขอ', $request->comment);
                    SentEmail($request->body['header']['approverID'], $requestNo, 'รอการอนุมัติจากผู้บังคับบัญชา', $request->comment);
                    return response()->json(array(
                        'status' => true,
                        'last_insert_id' => $requestOT
                    ));
                } else if ($request->id != null) {
                    $requestOT = Request_ot::where('id', $request->id)->update(array(
                        //from Back
                        // 'requestNo' => ($request->body['header']['requestNo'] == null) ? CreateRequestNo($request->body['header']['requestDate']) : $request->body['header']['requestNo'],
                        'requestNo' => $requestNo,
                        'requestStatus_No' => 1,
                        'requestStatus' => 'รอการอนุมัติจากผู้บังคับบัญชา',
                        //from Font
                        'requestDate' => Carbon::createFromFormat('d/m/Y', $request->body['header']['requestDate'])->format('Y-m-d'),
                        'employeeID' => $request->body['header']['employeeID'],
                        'employeeName' => $request->body['header']['employeeName'],
                        'department' => $request->body['header']['department'],
                        'approverID' => $request->body['header']['approverID'],
                        'approverName' => $request->body['header']['approverName'],
                        'salary' => $request->body['header']['salary'],
                        'shift' => $request->body['header']['shift'],
                        'shiftTime' => $request->body['header']['shiftTime'],
                        'shiftBreak' => $request->body['header']['shiftBreak'],
                        'shiftWeekend' => $request->body['header']['shiftWeekend'],
                        'shiftMinus_hours' => $request->body['header']['shiftMinus_hours'],
                        'price_of_hours' => $request->body['header']['price_of_hours'],
                        'totalprice_ot' => $request->body['total']['price'],
                        'assignTo' => $request->body['header']['approverID'],
                        'assignTo_name' => $request->body['header']['approverName'],
                        // 'comment'=>$request->comment
                    ));
                    insertDetail($request->id, $request->body['detail']);
                    insertHistory($request->id, $request->action_by, 'ส่งโดยผู้ร้องขอ', $request->comment);
                    SentEmail($request->body['header']['approverID'], $requestNo, 'รอการอนุมัติจากผู้บังคับบัญชา', $request->comment);

                    return response()->json(array(
                        'status' => true,
                        'last_insert_id' => $request->id
                    ));
                }
                break;
            case 'ApproveBySub':
                Request_ot::where('id', $request->id)->update(array(
                    //from Back
                    'requestStatus_No' => 2,
                    'requestStatus' => 'กำลังรอการอนุมัติจากผู้ดูแลระบบ',
                    'assignTo' => $request->admin,
                    'assignTo_name' => $request->admin_name,
                ));
                insertHistory($request->id, $request->action_by, 'ได้รับการอนุมัติจากผู้บังคับบัญชา', $request->comment);
                SentEmail($request->admin, $request->request_no, 'กำลังรอการอนุมัติจากผู้ดูแลระบบl', $request->comment);

                return response()->json(array(
                    'status' => true,
                ));
                break;
            case 'ApproveByAdmin':
                $requestOT = Request_ot::where('id', $request->id)->get();
                Request_ot::where('id', $request->id)->update(array(
                    //from Back
                    'requestStatus_No' => 3,
                    'requestStatus' => 'สมบูรณ์',
                    'assignTo' => null,
                    'assignTo_name' => null,
                ));
                insertHistory($request->id, $request->action_by, 'อนุมัติโดยผู้ดูแลระบบ', $request->comment);
                return response()->json(array(
                    'status' => true,
                ));
                SentEmail($requestOT[0]->employeeID, $request->request_no, 'สมบูรณ์', $request->comment);
            case 'ReturnBySub':
                $requestOT = Request_ot::where('id', $request->id)->get();
                Request_ot::where('id', $request->id)->update(array(
                    //from Back
                    'requestStatus_No' => 6,
                    'requestStatus' => 'ส่งคืนโดยผู้บังคับบัญชา',
                    'assignTo' => $requestOT[0]->employeeID,
                    'assignTo_name' => $requestOT[0]->employeeName,
                ));
                insertHistory($request->id, $request->action_by, 'ส่งคืนโดยผู้บังคับบัญชา', $request->comment);
                SentEmail($requestOT[0]->employeeID, $request->request_no, 'ส่งคืนโดยผู้บังคับบัญชา', $request->comment);

                return response()->json(array(
                    'status' => true,
                ));
                break;
            case 'ReturnByAdmin':
                $requestOT = Request_ot::where('id', $request->id)->get();
                Request_ot::where('id', $request->id)->update(array(
                    //from Back
                    'requestStatus_No' => 6,
                    'requestStatus' => 'ส่งคืนโดยผู้ดูแลระบบ',
                    'assignTo' => $requestOT[0]->employeeID,
                    'assignTo_name' => $requestOT[0]->employeeName,
                ));
                insertHistory($request->id, $request->action_by, 'ส่งคืนโดยผู้ดูแลระบบ', $request->comment);
                SentEmail($requestOT[0]->employeeID, $request->request_no, 'ส่งคืนโดยผู้ดูแลระบบ', $request->comment);

                return response()->json(array(
                    'status' => true,
                ));
                break;
            case 'CancelBySub':
                $requestOT = Request_ot::where('id', $request->id)->get();
                Request_ot::where('id', $request->id)->update(array(
                    //from Back
                    'requestStatus_No' => 9,
                    'requestStatus' => 'ยกเลิกโดยผู้บังคับบัญชา',
                    'assignTo' => null,
                    'assignTo_name' => null,
                ));
                insertHistory($request->id, $request->action_by, 'ยกเลิกโดยผู้บังคับบัญชา', $request->comment);
                SentEmail($requestOT[0]->employeeID, $request->request_no, 'ยกเลิกโดยผู้บังคับบัญชา', $request->comment);

                return response()->json(array(
                    'status' => true,
                ));

            case 'CancelByAdmin':
                $requestOT = Request_ot::where('id', $request->id)->get();
                Request_ot::where('id', $request->id)->update(array(
                    //from Back
                    'requestStatus_No' => 9,
                    'requestStatus' => 'ยกเลิกโดยผู้ดูแลระบบ',
                    'assignTo' => null,
                    'assignTo_name' => null,
                ));
                insertHistory($request->id, $request->action_by, 'ยกเลิกโดยผู้ดูแลระบบ', $request->comment);
                SentEmail($requestOT[0]->employeeID, $request->request_no, 'ยกเลิกโดยผู้ดูแลระบบ', $request->comment);

                return response()->json(array(
                    'status' => true,
                ));
                break;
            case 'GetByID':
                $Request_ot = Request_ot::where('id', $request->id)->get();
                return Request_otResource::collection($Request_ot);
                break;
            case 'GetAllRequest_TODO':
                $Request_ot = Request_ot::where('assignTo', $request->assignTo)
                    ->orderBy('updated_at', 'DESC')
                    ->get();
                return $Request_ot;
                break;
            case 'GetAllRequest_myRequest':
                $Request_ot = Request_ot::where('employeeID', $request->employeeID)
                    ->orderBy('updated_at', 'DESC')
                    ->get();
                return $Request_ot;
                break;
            case 'Delete':
                Request_ot_Detail::where('request_ot_id', $request->id)->delete();
                Request_ot::where('id', $request->id)->delete();
                return response()->json(array(
                    'status'    =>  true,
                    'message'   =>  'ลบสำเร็จ'
                ));
                break;
            case 'GetPdf':
                $pdf = generatePDF($request->id);
                return response()->json(array(
                    'status'    =>  true,
                    'file'   =>   $pdf
                ));
            case 'GetReqComplete':
                $Request_ot = Request_ot::where('requestStatus_No', 3)
                    ->where(function ($query) use ($request) {
                        $query->where('requestNo', 'like', '%' . $request->requestNo . '%')
                            ->where('department', 'like', '%' . $request->department . '%')
                            ->where('shift', 'like', '%' . $request->shift . '%')
                            ->where(function ($query) use ($request) {
                                if ($request->requestDate_from && $request->requestDate_to) {
                                    $query->whereBetween('requestDate', [$request->requestDate_from, $request->requestDate_to]);
                                } elseif ($request->requestDate_from) {
                                    $query->where('requestDate', '>=', $request->requestDate_from);
                                } elseif ($request->requestDate_to) {
                                    $query->where('requestDate', '<=', $request->requestDate_to);
                                }
                            });
                    })
                    ->where(function ($query) use ($request) {
                        $query->where('employeeID', 'like', '%' . $request->employee . '%')
                            ->orwhere('employeeName', 'like', '%' . $request->employee . '%');
                    })
                    ->get();
                return $Request_ot;
                break;
            case 'GetDepartmentAll':
                $department = Request_ot::distinct()->get('department');
                return $department;
            case 'GetShiftAll':
                $shift = Request_ot::distinct()->get('shift');
                return $shift;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request_ot  $request_ot
     * @return \Illuminate\Http\Response
     */
    public function show(Request_ot $request_ot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Request_ot  $request_ot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Request_ot $request_ot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request_ot  $request_ot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request_ot $request_ot)
    {
        //
    }

    // public function generatePDF()
    // {
    //     $head = Request_ot::where('id', 108)->get();
    //     $detail = Request_ot_Detail::where('request_ot_id', 108)->get();


    //     $pdf = PDF::loadView('pdf', [
    //         'head' => $head,
    //         'detail' => $detail
    //     ]);

    //     return @$pdf->stream();

    // }
}
