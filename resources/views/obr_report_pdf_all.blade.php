
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
    <br>
    <table width='100%'>
        <tr>
            <td width='70%'>
                OBR MONTH : {{date('F Y', strtotime($date_select))}} 
            </td>
            <td width='10%' align='center'>{{$resident_count}}
                <div class='green'> </div>resident
            </td>
            <td width='10%' align='center'>{{$non_resident_count}}
                <div class='violet'> </div>non-resident
            </td>
            <td width='10%' align='center'>{{$unknown}}
                <div class='grey'> </div>unknown
            </td>
        </tr>
    </table>
    
    
    
    <table border='1' >
        <tr style='background-color:yellow;'>
            <td width='20%'>
                Name
            </td>
            <td width='7%'>
                Lot Number
            </td>
            <td align='center' width='10%'>
                Previous Principal
            </td>
            <td align='center' width='10%'>
                Previous Interest
            </td>
            <td align='center' width='10%'>
                Payment Received
            </td>
            <td align='center' width='8%'>
                Discount
            </td>
            <td align='center' width='10%'>
                Adjustment
            </td>
            <td align='center' width='7%'>
                Interest
            </td>
            <td align='center' width='8%'>
                Association Dues
            </td>
            <td align='center' width='10%'>
                Total Amount Due
            </td>
            
        </tr>
        @php
        $total = 0;
        $total_association_dues = 0;
        @endphp
        @foreach($soa_payments as $key => $soa_payment)
        @php
        $last_payment = $payments[$key];
        $total_current_charges = ($soa_payment->special_assessment+$soa_payment->others+($soa_payment->rate * $soa_payment->lot_size));
        $amount_due = $soa_payment->rate * $soa_payment->lot_size;
        $total_overdue_charges = $soa_payment->previos_bill+$soa_payment->previos_interest-$soa_payment->discount-$last_payment;
        if(($soa_payment->previos_bill - $last_payment) <= 0)
        {
            $latest_interest = 0;
        }
        else
        {
            $latest_interest = $soa_payment->previos_bill*.02;
        }
        $sub_total = $total_overdue_charges + $latest_interest - $soa_payment->adjustment;
        $total_amout_due = $sub_total + $total_current_charges;
        @endphp
        <tr>
            <td>
                {{str_limit($soa_payment->client_name, 25)}}
            </td>
            <td>
                {{$soa_payment->client_lot_number}}
            </td>
            <td align='right'>
                {{number_format(($soa_payment->previos_bill),2)}}
            </td>
            <td align='right'>
                {{number_format(($soa_payment->previos_interest),2)}}
            </td>
            
            <td align='right'>
                {{number_format(($last_payment),2)}}
            </td>
            <td align='right'>
                {{number_format(($soa_payment->discount),2)}}
            </td>
            
            <td align='right'>
                {{number_format(($soa_payment->adjustment),2)}}
            </td>
            <td align='right'>
                {{number_format(($latest_interest),2)}}
            </td>
            <td align='right'>
                {{number_format(($soa_payment->rate * $soa_payment->lot_size),2)}}
            </td>
            
            @if($soa_payment->client_status == 'resident')
            <td align='right' style='background-color:green;'>
                {{number_format(($total_amout_due),2)}}
            </td>
            @elseif($soa_payment->client_status == 'non-resident')
            <td align='right' style='background-color:blueviolet;'>
                {{number_format(($total_amout_due),2)}}
            </td>
            @else
            <td align='right' style='background-color:grey;'>
                {{number_format(($total_amout_due),2)}}
            </td>
            @endif
        </tr>
        @php
        $total_association_dues = $total_association_dues + $amount_due;
        $total = $total + $total_amout_due;
        @endphp
        @endforeach
        <tr style='background-color:yellow;'>
            <td colspan='8'>
            </td>
            <td colspan='1'  align='right'>
                {{number_format(($total_association_dues),2)}}
            </td>
            <td align='right' colspan='1'>
                {{number_format(($total),2)}}
            </td>
        </tr>
    </table>
</body>
</html>


