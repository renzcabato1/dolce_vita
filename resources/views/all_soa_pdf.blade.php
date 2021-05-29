
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
    @foreach($soa_payments as $key => $soa_payment)
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style='font-size:16px' >
        <tr>
            <td valign="top"  width='15%'>
                Name
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='34%'>
                {{$soa_payment->client_name}}
            </td>
            @php
            if(($soa_payment->billing_number/10) < 1 )
            {
                $soa_number = 'SOA-'.date('Y-m',(strtotime($soa_payment->date_soa))).'-00'.$soa_payment->billing_number;
            }
            else if(($soa_payment->billing_number/10) < 10 )
            {
                $soa_number = 'SOA-'.date('Y-m',(strtotime($soa_payment->date_soa))).'-0'.$soa_payment->billing_number;
            }
            else 
            {
                $soa_number = 'SOA-'.date('Y-m',(strtotime($soa_payment->date_soa))).'-'.$soa_payment->billing_number;
            }
            @endphp
            <td valign="top"  width='15%'>
                Billing Statement
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='34%'>
                {{$soa_number}}
            </td>
        </tr>
        <tr>
            <td valign="top" >
                HOA ID
            </td>
            <td valign="top" >
                :
            </td>
            <td valign="top" >
                {{$soa_payment->client_hoa_id}}
            </td>
            <td valign="top" >
                Lot Number
            </td>
            <td valign="top" >
                :
            </td>
            <td valign="top" >
                {{$soa_payment->client_lot_number}}
            </td>
        </tr>
        <tr>
            <td valign="top" >
                Address
            </td>
            <td valign="top" >
                :
            </td>
            <td valign="top" >
                {{$soa_payment->client_address}}
            </td>
            <td valign="top"  >
                Status
            </td>
            <td valign="top" >
                :
            </td>
            <td valign="top" >
                {{$soa_payment->client_status}}
            </td>
        </tr>
    </table>
    <br>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style='font-size:16px' >
        <tr>
            <td valign="top"  width='15%'>
                
            </td>
            <td valign="top"  width='1%'>
                
            </td>
            <td valign="top"  width='34%'>
                
            </td>
            <td valign="top"  width='20%'>
                <u>Association Dues</u>
            </td>
            
        </tr>
        <tr>
            <td valign="top"  width='10%'>
                Date Billed
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='39%'>
                {{date('F d, Y',strtotime($soa_payment->date_billed))}}
            </td>
            <td valign="top"  width='20%'>
                Lot size(sq. m.)
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='29%'>
                {{$soa_payment->lot_size}}
            </td>
        </tr>
        <tr>
            <td valign="top"  width='10%'>
                Date Due
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='39%'>
                {{date('F d, Y',strtotime($soa_payment->date_due))}}
            </td>
            <td valign="top"  width='20%'>
                Dues Rates/sq.m.month
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='29%'>
                {{$soa_payment->rate}}
            </td>
        </tr>
        <tr>
            <td valign="top"  width='10%'>
                Period Covered
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='39%'>
                Month of {{date('F Y',strtotime($soa_payment->date_due))}}
            </td>
            <td valign="top"  width='20%'>
                No. of Month/s
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='29%'>
                1
            </td>
        </tr>
    </table>
    <br>
    <table width="100%" cellspacing="0"  style='font-size:16px' frame="box">
        <tr>
            <td valign="top" colspan='3'  >
                <b>Overdues Charges</b>
            </td>
            <td valign="top" colspan='3'  >
                <b>Current Charges:</b>
            </td>
        </tr>
        <tr>
            <td valign="top"  width='27%' >
                <span style="padding-left: 10px;">Balance from Previous Bill</span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='23%' style='text-align:right;padding-right:50px;'>
                {{number_format(($soa_payment->previos_bill),2)}}
            </td>
            <td valign="top"  width='20%'>
                <span style="padding-left: 10px;">Association Dues</span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='20%' style='text-align:right;padding-right:100px;'>
                {{number_format(($soa_payment->rate * $soa_payment->lot_size),2)}}
            </td>
        </tr>
        <tr>
            <td valign="top"  width='27%' >
                <span style="padding-left: 10px;">Previous Total Interest:</span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='23%' style='text-align:right;padding-right:50px;'>
                {{number_format(($soa_payment->previos_interest),2)}}
            </td>
            <td valign="top"  width='20%' >
                <span style="padding-left: 10px;">Special Assessment</span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='20%' style='text-align:right;padding-right:100px;'>
                {{number_format(($soa_payment->special_assessment),2)}}
            </td>
        </tr>
        <tr>
            <td valign="top"  width='27%'>
                <span style="padding-left: 10px;">Payment Received(thank you!)</span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='23%' style='text-align:right;padding-right:50px;'>
                @php
                $last_payment = $payments[$key];
                @endphp
                {{number_format(($last_payment),2)}}
            </td>
            <td valign="top"  width='20%'>
                <span style="padding-left: 10px;">Others</span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='20%' style='text-align:right;padding-right:100px;'>
                {{number_format(($soa_payment->others),2)}}
            </td>
            
        </tr>
        <tr>
            <td valign="top"  width='27%'>
                <span style="padding-left: 10px;">Discount</span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top" width='23%' style='text-align:right;padding-right:50px;'>
                {{number_format(($soa_payment->discount),2)}}
            </td>
            <td colspan='3'>
            </td>
            
        </tr>
        <tr>
            <td valign="top"   width='24%' >
                <b>Total Overdue Charges   </b>
            </td>
            <td valign="top"  width='2%' >
                :
            </td>
            <td valign="top" width='23%' style='text-align:right;padding-right:50px;'>
                @php
                $total_overdue_charges = $soa_payment->previos_bill+$soa_payment->previos_interest-$soa_payment->discount-$last_payment;
                if(($soa_payment->previos_bill - $last_payment) <= 0)
                {
                    $latest_interest = 0;
                }
                else
                {
                    $latest_interest = ($soa_payment->previos_bill - $last_payment)*.02;
                }
                @endphp
                
                {{number_format(($total_overdue_charges),2)}}
            </td>
            <td valign="top" width='25%'>
                <b>Total Current Charges:</b>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='20%' style='text-align:right;padding-right:100px;'>
                @php
                $total_current_charges = ($soa_payment->special_assessment+$soa_payment->others+($soa_payment->rate * $soa_payment->lot_size));
                @endphp
                {{number_format($total_current_charges,2)}}
                
            </td>
        </tr>
        <tr>
            <td valign="top"  width='27%' >
                <span style="padding-left: 10px;">Adjustment</span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='23%' style='text-align:right;padding-right:50px;'>
                {{number_format(($soa_payment->adjustment),2)}}
            </td>
            <td colspan='3'></td>
            
        </tr>
        <tr>
            <td valign="top"  width='27%'>
                <span style="padding-left: 10px;">Interest</span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='23%' style='text-align:right;padding-right:50px;'>
                {{number_format(($latest_interest),2)}}
            </td>
            <td valign="top"  colspan='3' width='20%'>
                <span style="padding-left: 10px;">Note: Advance Payment is in Negative(-).</span>
            </td>
        </tr>
        <tr>
            <td valign="top"  width='27%'>
                <span style="padding-left: 10px;"><i><b>Sub Total</b></i></span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='23%' style='text-align:right;padding-right:50px;'>
                @php
                
                $sub_total = $total_overdue_charges + $latest_interest - $soa_payment->adjustment;
                $total_amout_due = $sub_total + $total_current_charges;
                
                @endphp
                
                {{number_format(($sub_total),2)}}
            </td>
            <td valign="top"  width='24%'>
                <span style="padding-left: 10px;"><i><b>Total Amount Due</b></i></span>
            </td>
            <td valign="top"  width='1%'>
                :
            </td>
            <td valign="top"  width='25%' style='text-align:right;padding-right:100px;'>
                {{number_format(($total_amout_due),2)}}
            </td>
        </tr>
    </table>
    <p style='font-size:10px;'><b>Note:</b>	<br>				
        1.Please pay directly to Admin Office during office hours and present this BIlling Statement when paying, pay on or before dute date to avoid any inconvenience.<br>
        2. Please always ask for Official Receipt upon payment.	<br>					
        3. For check Payment, please make check payable to: Villaggio di Xavier Dolce Vita HOA, Inc.			<br>			
        4. Check payment shall be crossed "for Payees Account only" , 2nd endorsed checks shall not be honored.	<br>					
        5. You may also deposit payment to <b>Asia United Bank-(Any Branch), Bank Acct No. 101-01-000245-7 Acct Name: Villaggio di Xavier Dolce Vita HOA, Inc.	</b><br>					
        6. If Payment was made thru bank, indicate your full registered home, HOA ID(found in the billing statement), your Lot # & your contact # at your deposit slip then kindly call us or email to <b>VDX.DolceVita.HOAI.2020@gmail.com.</b>	<br>
        7. For inquiries please contact our village Admin. <b>Ms. Annaliza Medenilla at Cp # (0931) 791-2960.</b><br>			
        8. Payment/s will be reflected on the next month billing statement.<br><b>REMINDER: Advance Payment for 1 year will be given 1 (One) month free of Association Dues.<br>	*If there are still un-posted payment comparative with your record, please let us know so that we can make the necessary adjustments.</b>
    </p>
    <div class="page-break"></div>
    @endforeach
</body>
</html>


