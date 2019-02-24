
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
    Payment for SOA
    <table border='1' >
        <tr style='background-color:yellow;'>
            <td>
                Name
            </td>
            <td>
              Lot Number
            </td>
            <td align='center'>
                Date Paid
            </td>
            <td align='center' >
               Type
            </td>
            <td align='center' >
                OR Number
            </td>
            <td align='center' >
                Remarks
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
                        {{str_limit($result->client_name, 22)}}
                </td>
                <td width='10%'>
                        {{$result->lot_number}}
                </td>
                <td align='left' width='15%'>
                        {{date('M. d, Y', strtotime($result->date_paid))}}
                </td>
                <td align='left' width='10%'>
                        {{$result->type}}
                </td>
                <td align='left' width='10%'>
                        {{$result->or_number}}
                </td>
                <td align='left' width='20%'>
                        {{$result->remarks}}
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
            <td colspan = '7'  align='right'>
                Total : {{number_format($total,2)}}
            </td>
        </tr>
    </table>
</body>
</html>


