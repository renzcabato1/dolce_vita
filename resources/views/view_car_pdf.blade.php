
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="icon" type="image/png" href="{{ asset('/images/icon.png')}}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        table { 
            border-spacing: 0;
            border-collapse: collapse;
        }
        body{
            font-family: Calibri;
            font-size:12px; 
        }
    </style>
</head>
<body>
<div style=' border: 1px solid black;width:50%;'>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr >
                <td  align='center' width='100px'> 
                    <img src='{{ asset('navbar/img/brand/blue.png')}}' width='90px' >
                </td>
                <td valign="top">
                    <p valign="top" style='font-size:11px;'><b>CASH ACKNOWLEDGEMENT RECEIPT</b>
                    </p>
                    @php
                    if(($careceipt->ca_number/10) < 1 )
                    {
                        $car_number = date('Y-m',(strtotime($careceipt->created_at))).'-00'.$careceipt->ca_number;
                    }
                    else if(($careceipt->ca_number/10) < 10 )
                    {
                        $car_number = date('Y-m',(strtotime($careceipt->created_at))).'-0'.$careceipt->ca_number;
                    }
                    else 
                    {
                        $car_number = date('Y-m',(strtotime($careceipt->created_at))).'-'.$careceipt->ca_number;
                    }
                    @endphp
                    <p style='float:right;font-size:12px;'>No.:  <b>{{$car_number}}</b>
                    </p>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top">
                    <p style='float:right;font-size:12px;'>Date:  <b>{{date('M. d, Y', strtotime($careceipt->date))}}</b></p>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr align='left'>
                <td valign="top">
                    <p style='font-size:16px;'>Received from <b><u>{{$careceipt->name}}</u></b> of <b><u>{{$careceipt->for_what}}</u></b> the cash amount of <b><u>{{$careceipt->amount_word. ' (PHP '. number_format($careceipt->amount,2).')' }}</u></b> as payment for <b><u>{{$careceipt->as_payment}}</u></b>.</p>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr align='left'>
                <td valign="top">
                    <p style='float:right;font-size:14px;'> By: <b><u>{{$name_by->name}}</u></b></p>
                </td>
            </tr>
        </table>
        </div>
</body>
</html>


