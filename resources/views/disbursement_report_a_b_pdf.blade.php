
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
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td  align='center' width='100px'> 
                <img src='{{ asset('navbar/img/brand/blue.png')}}' width='90px' >
            </td>
            <td valign="top">
                <p valign="top"><b>VILLAGIO DI XAVIER DOLCE VITA HOMEOWNERS ASSOCIATION INC.</b><br>
                    BINAN CITY LAGUNA
                </p>
            </td>
        </tr>
    </table>
    <br>
    Date Coverage : {{date('F d, Y', strtotime($date_from))}} to  {{date('F d, Y', strtotime($date_to))}} <br>
    
    Bank Account Number : {{$check_type}} <br>
    Disbursement Report
    <table border='1' >
        <tr style='background-color:yellow;'>
            <td>
                Payee
            </td>
            <td>
                Check Date
            </td>
            <td align='center'>
                Particulars
            </td>
            <td align='center' >
                CV Number
            </td>
            <td align='center' >
                RPLF Number
            </td>
            <td align='center' >
                Check Number
            </td>
            <td align='center' >
                Reference
            </td>
            <td align='center'>
                Amount
            </td>
        </tr>
        @php
            $total = 0;
        @endphp
        @foreach($results as $result)

        <tr>
                <td width='25%'>
                        {{str_limit($result->payee, 22)}}
                </td>
                <td width='10%'>
                    {{date('M. d, Y', strtotime($result->check_date))}}
                </td>
                <td align='left' width='15%'>
                    {{$result->particulars}}
                </td>
                <td align='left' width='10%'>
                    {{$result->cv_number}}
                </td>
                <td align='left' width='10%'>
                    {{$result->rplf_number}}
                </td>
                <td align='left' width='20%'>
                    {{$result->check_number}}
                </td>
                <td align='left' width='20%'>
                    {{$result->reference}}
                </td>
                <td align='right' width='20%'>
                      {{number_format($result->amount,2)}}
                </td>
            </tr>
            @php
                $total = $total + $result->amount;
            @endphp
        @endforeach
        <tr style='background-color:yellow;'>
            <td colspan = '8'  align='right'>
                Total : {{number_format($total,2)}}
            </td>
        </tr>
    </table>
</body>
</html>


