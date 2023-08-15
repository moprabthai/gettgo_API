<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
            display: block;
            color: #ffffff;
            background-color: #e91681;
            width: 45%;
            text-align: center;
            border: 5px solid #e91681;
            border-radius: 4px;
            font-size: 14px;

        }
    </style>
</head>

<body style="background-color: #FFFFFF;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF;">
        <tbody>
            <tr style="background-color: #122e43;height:100px;">
                <td colspan="3">

                </td>
            </tr>
            <tr style="background-image: url('http://moprabthai.thddns.net:9090/api/public/storage/mail/bgmail.jpg');height:300px;background-size: cover;">
                <td colspan="2" style="text-align: right;width:90%">
                    <div>
                        <span style="font-size:28px;color: #0a0048;">
                            สวัสดีคุณ {{$employee}}<br>Welcome to Overtime system
                        </span>
                    </div>
                </td>
                <td style="text-align: right;">

                </td>
            </tr>
            <tr style="background-color:#f0f0f0;">
                <td colspan="3" style="text-align: center;">
                    <div style="padding-top: 20px;">
                        <div class style="color: #333333; line-height: 1.8;">
                            <p style="margin: 0;">
                                <span style="font-size:24px;">
                                    <strong>มีใบงานถึงคุณ!<br></strong>
                                </span>
                            </p>
                        </div>
                    </div>
                </td>
            <tr style="background-color:#f0f0f0;">
                <td style="width:50%">

                    <div style="font-size: 14px;text-align: right;  color: #A5A5A6; line-height: 1.8;">
                        <p style="margin: 0; "><span>เลขที่ใบงาน :</span></p>
                        <p style="margin: 0; "><span>สถาณะใบงาน :</span></p>
                        <p style="margin: 0; "><span>ข้อความ :</span></p>
                    </div>

                </td>
                <td colspan="2">
                    <div style="font-size: 14px;text-align: left;  color: #A5A5A6; line-height: 1.8; margin-left: 10px;">
                        <p style="margin: 0; "><span>{{$requestno}}</span></p>
                        <p style="margin: 0; "><span>{{$requeststatus}}</span></p>
                        <p style="margin: 0; "><span>{{$comment = is_null($comment) ? '-' : $comment;}}</span></p>
                    </div>
                </td>
            </tr>
            <tr style="background-color:#f0f0f0;">
                <td colspan="3" style="padding:15px 15px">
                    <div class="alignment" align="center">
                        <a href="http://moprabthai.thddns.net:9090/" target="_blank">
                            <strong style="color: #ffffff;">
                                คลิกที่นี่
                            </strong>
                        </a>
                    </div>
                </td>
            </tr>
            <tr style="background-color: #122e43;height:100px;">
                <td colspan="3">

                    <div style="font-size: 12px; text-align: center;  color: #959595;">
                        <p>@Create by Information Technology of Southeast Bangkok University</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>
