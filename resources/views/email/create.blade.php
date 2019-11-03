<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN""http://www.w3.org/TR/REC-html40/loose.dtd">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Incident Email</title>
</head>
<body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="full" bgcolor="#ffffff" style="background-color: #ffffff;">
        <tr>
            <td height="100" class="h25" width="100%" style="font-size: 1px; line-height: 1px;">&nbsp;</td>
        </tr>
        <tr>
            <td align="center" valign="top" bgcolor="#ffffff">
                <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td align="center">
                                <table width="599" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <tr>
                                                            <td width="40"></td>
                                                            <td width="100">
                                                                <img src="https://gallery.mailchimp.com/97a4e1ef275b75553aa975996/images/ec6602d4-c90f-4aaf-af5e-8bced0497d22.png" width="90" height="45" alt="CHASE" style="display:block" border="0" class="CToWUd">
                                                            </td>
                                                            <td><h2 style="padding-top:10px">IT Help Desk</h2></td>
                                                        </tr>
                                                    </tbody>
                                                </table>                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 0 17px 0">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td bgcolor="#ffffff" style="padding:0 10px 18px">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="padding:12px 0 12px 27px">                                
                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td colspan="3"><h4>&nbsp;&nbsp;&nbsp;Ticket Reference : {{$incident->reference_number}}</h4><br></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td width="10"></td>
                                                                                                            <td style="vertical-align:top;font-family:verdana,arial,helvetica,sans-serif;font-size:12px">
                                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                                    <tr>
                                                                                                                        <td align="right" width="150">Caller :&nbsp;&nbsp;</td>
                                                                                                                        <td>{{$incident->user->name ?? ''}}</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td align="right" width="150">Category :&nbsp;&nbsp;</td>
                                                                                                                        <td>{{$incident->category->name ?? ''}}</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td align="right" width="150">Urgency :&nbsp;&nbsp;</td>
                                                                                                                        <td>
                                                                                                                            @if ($incident->urgency)
                                                                                                                                High
                                                                                                                            @else
                                                                                                                                Low
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td align="right" width="150">Priority :&nbsp;&nbsp;</td>
                                                                                                                        <td>{{$incident->priority}}</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td align="right" width="150" valign="top">Fault Description :&nbsp;&nbsp;</td>
                                                                                                                        <td><pre>{{$incident->description}}</pre></td>
                                                                                                                    </tr>
                                                                                                                </table>
                                                                                                            </td>
                                                                                                            <td width="10"></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td colspan="3" style="padding:17px 15px 27px 10px;font-family:verdana,arial,helvetica,sans-serif;font-size:13px;">                                                                                                                
                                                                                                                <br />Thank you.
                                                                                                                <br /><br /><strong>Regards,</strong> 
                                                                                                                <br /><br /><strong>The Emirates IT Helpdesk Team</strong> 
                                                                                                                <br /><br />This is a system generated email notification, please do not reply.
                                                                                                            </td></tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td height="15" width="100%" style="font-size: 1px; line-height: 1px;">&nbsp;</td>
        </tr>
        <tr>
            <td height="1" width="100%" style="font-size: 1px; line-height: 1px;">&nbsp;</td>
        </tr>
    </table>
</body>
</html>