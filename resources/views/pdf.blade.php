<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$head[0]->requestNo}}</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            background-color: white;
            font-size: 18px;
        }

        h1 {
            color: maroon;
            margin-left: 40px;
        }



        .detail table,
        .detail td {
            border: 1px solid #c6e2ff;
            border-collapse: collapse;
        }

        .detail th {
            border: 1px solid #c6e2ff;
            border-collapse: collapse;
            background-color: #ed66d0;
            color: white;

        }

        .detail tr:nth-of-type(odd) {
            background: #ecefff;
        }

        .detail tr:nth-of-type(even) {
            background: white;
        }
    </style>
</head>

<body>
    <div style="text-align: center;">
        <img src="http://moprabthai.thddns.net:9090/api/public/storage/mail/iconpdf.jpg" alt="Flowers" width="190" height="50">
        <h2>รายงานการเบิกล่วงเวลา</h2>
    </div>
    <div class="head">
        <table style="width:100%">
            <tr>
                <td><b>เลขที่ใบ</b> : </td>
                <td>{{ $head[0]->requestNo }}</td>
                <td></td>
                <td><b>รหัสพนักงาน</b> : </td>
                <td>{{ $head[0]->employeeID }}</td>
            </tr>
            <tr>
                <td><b>ชื่อ-นามสกุล</b> : </td>
                <td>{{ $head[0]->employeeName }}</td>
                <td></td>
                <td><b>แผนก</b> : </td>
                <td>{{ $head[0]->department }}</td>
            </tr>
            <tr>
                <td><b>เงินเดือน</b> : </td>
                <td>{{ $head[0]->salary }} บาท</td>
                <td style="width: 25%;"></td>
                <td><b>โอที</b> : </td>
                <td>{{ $head[0]->totalprice_ot }} บาท</td>
            </tr>
        </table>
    </div>


    <div style="text-align: center;">
        <h3>
            รายละเอียด
        </h3>
    </div>
    <div class="detail">
        <table style="width:100%">
            <tr>
                <th>No</th>
                <th>เวลาเริ่ม</th>
                <th>เวลาออก</th>
                <th>ประเภท</th>
                <th>ราคาต่อชั่วโมง</th>
                <th>จำนวนชั่วโมง</th>
                <th>ราคาทั้งหมด</th>
                <th>หมายเหตุ</th>
            </tr>
            @foreach ($detail as $key=>$i)
            <tr>
                <td style="text-align: center;"> {{$key+1}}</td>
                <td style="text-align: center;"> {{$i->time_start}}</td>
                <td style="text-align: center;">{{$i->time_end}}</td>
                <td style="text-align: center;">{{$i->type}}</td>
                <td style="text-align: right;">{{$i->price_of_hours}}</td>
                <td style="text-align: center;">{{$i->total_hours}}</td>
                <td style="text-align: right;">{{$i->total_price}}</td>
                <td style="text-align: center;">{{$i->comment}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
