
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
        .green {
            width:10px;
            border: 10px solid green;
        }
        .violet {
            width:10px;
            border: 10px solid blueviolet;
        }
        .grey {
            width:10px;
            border: 10px solid gray;
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

             
    <table border='1' width='100%' style='text-align:left' >
           
            <tr>
                <th scope="col" colspan='12' >
                    Name : {{$cl->name}} <br>
                    Area : {{$cl->area}}<br>
                    Cost : 7<br>
                    Hoa ID : {{$cl->hoa_id}}<br>
                    Ph-Blk-Lot : {{$cl->lot_number}}<br>
                    Dues start date : {{date('M. Y',strtotime($cl->start_month))}}<br>
                </th>
            </tr>
            
            <tr  align='center'>
                <th scope="col" rowspan='2'>Applicable Month</th>
                <th scope="col" colspan='3'>Beginning Balance</th>
                <th scope="col" rowspan='2'>Monthly Dues</th>
                <th scope="col" rowspan='2'>Payment</th>
                <th scope="col" rowspan='2'>Montly Interest</th>
                <th scope="col" rowspan = 2>Principal Adjustment</th>
                <th scope="col" rowspan = 2>Interest Adjustment:</th>
                <th scope="col" colspan='3'>Ending Balance</th>
                
            </tr>
            <tr  align='center'>
                <th scope="col">Principal</th>
                <th scope="col">Interest</th>
                <th scope="col">Total</th>
                <th scope="col">Principal</th>
                <th scope="col">Interest</th>
                <th scope="col">Total</th>
                
            </tr>
        </thead>
        <tbody>
            @php
            $ending_principal = 0;
            $ending_interest = 0;
            $ending_total = 0;
            @endphp
            @foreach($soapayment as $key => $soa)
            <tr>
                <td>{{date('M. Y',strtotime($soa->date_due))}}
                </td>
                @if($key == 0)
                @php
                    $ending_principal = $soa->previos_bill;
                    $ending_interest = $soa->previos_interest;
                    $ending_total = $soa->previos_bill+$soa->previos_interest
                @endphp
                 <td style='text-align:right;'>
                    {{number_format($ending_principal,2)}}
                </td>
                <td style='text-align:right;'>
                    {{number_format($ending_interest,2)}}
                </td>
                <td style='text-align:right;'>
                    {{number_format($ending_total,2)}}
                </td>
                @else
                <td style='text-align:right;'>
                    {{number_format($ending_principal,2)}}
                </td>
                <td style='text-align:right;'>
                    {{number_format($ending_interest,2)}}
                </td>
                <td style='text-align:right;'>
                    {{number_format($ending_total,2)}}
                </td>
                @endif
                
                <td style='text-align:right;'>
                    {{number_format(7*$cl->area,2)}}
                </td>
                <td style='text-align:right;'>
                    {{number_format(($data[$key]['payment']),2)}}
                </td>
                <td style='text-align:right;'>
                    @php
                    $rate_interest = $ending_principal;
                    if($rate_interest <= 0)
                    {
                        $interest_rate = 0;
                    }
                    else 
                    {
                        $interest_rate =  $rate_interest * .02;
                    }
                    @endphp
                    {{number_format($interest_rate,2)}}
                </td >
                <td style='text-align:right;'>
                    {{number_format($soa->discount,2)}}
                </td>
                <td style='text-align:right;'>
                    {{number_format($soa->adjustment,2)}}
                </td>
                <td style='text-align:right;'>
                    @php
                    $principal = $ending_principal + (7*$cl->area) - $soa->discount - $data[$key]['payment'];
                    $ending_principal = $principal;
                    @endphp
                    {{number_format($ending_principal,2)}}
                </td>
                <td style='text-align:right;'>
                    @php
                    $total_interest = $ending_interest + $interest_rate - $soa->adjustment ;
                    $total_ending_balance = $total_interest +  $principal;
                    $ending_interest =  $total_interest;
                    $ending_total = $total_ending_balance ;
                    @endphp
                    {{number_format($ending_interest,2)}}
                </td>
                <td style='text-align:right;'>
                    {{number_format($total_ending_balance,2)}}
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
</body>
</html>


