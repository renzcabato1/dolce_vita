<?php

namespace App\Http\Controllers;
use PDF;
use App\Soapayment;
use App\Client;
use App\Obr;
use App\Payment;
use App\Careceipt;
use Illuminate\Http\Request;
use App;

class PaymentController extends Controller
{
    //
    public function view_soa_pdf($id)
    {
        
        $soa_payment = Soapayment::findOrfail($id);
        $client = Client::findOrfail($soa_payment->client_id);
        $soa_old = Soapayment::where('done',1)->where('client_id',$soa_payment->client_id)->orderBy('date_soa','desc')->first();
        if($soa_old == null)
        {
            $last_payment = 0;
        }
        else
        {
            $payment = Payment::where('soa_number',$soa_old->id)->first();
            if($payment == null)
            {
                $last_payment = 0;
            }
            else
            {
                $last_payment = $payment->amount;
            }
        }
        $pdf = PDF::loadView('soa_pdf',array(
            'soa_payment' => $soa_payment,
            'client' => $client,
            'last_payment' => $last_payment,
        ));
        return $pdf->stream('soa.pdf');
    }
    public function soa()
    {
        $soa_payments = Soapayment::where('done','0')
        ->leftJoin('clients','soapayments.client_id','=','clients.id')
        ->leftJoin('payments','soapayments.id','=','payments.soa_number')
        ->select('soapayments.*','clients.name as client_name','clients.lot_number as client_lot_number','clients.hoa_id as client_hoa_id','clients.address as client_address','payments.amount as payment',
        'payments.remarks as payment_remarks','payments.date_paid as payment_date','payments.type as payment_type','payments.or_number as or_number','payments.id as payment_id')
        ->get();
        $soa_last_month = Soapayment::orderBy('id','desc')->first();
        $name_of_month =  date(('F'),strtotime($soa_last_month->date_soa));
        return view('soa',array (
            'soa_payments' => $soa_payments,                
            'name_of_month' => $name_of_month,    
            'soa_last_month' => date("Y-m",(strtotime(date("Y-m", strtotime($soa_last_month->date_soa)) . " +1 month"))), 
        ));
    }
    public function print_all_soa()
    {
        $soa_payments = Soapayment::where('done','0')
        ->leftJoin('clients','soapayments.client_id','=','clients.id')
        ->select('soapayments.*','clients.name as client_name','clients.lot_number as client_lot_number','clients.hoa_id as client_hoa_id','clients.address as client_address','clients.status as client_status')
        ->get();
        $payments = [];
        foreach($soa_payments as $soa_payment){
            $soa_old = Soapayment::where('done',1)->where('client_id',$soa_payment->client_id)->orderBy('date_soa','desc')->first();
            if($soa_old == null)
            {
                $payments[] = 0;
            }
            else
            {
                $payment = Payment::where('soa_number',$soa_old->id)->first();
                if($payment == null)
                {
                    
                    $payments[] = 0;
                }
                else
                {
                    $payments[] = $payment->amount;
                }
            }
        }
        $pdf = PDF::loadView('all_soa_pdf',array(
            'soa_payments' => $soa_payments,
            'payments' => $payments,
        ));
        
        return $pdf->stream('soa_all.pdf');
    }
    public function generate_soa(Request $request)
    {
        $month = $request->month_of_soa;
        $last_date_of_soa = date("Y-m-t", strtotime($month));
        $final = $month.'-15';
        $date_billed_mo = $month.'-25';
        $date_billed = date("Y-m-d",(strtotime(date("Y-m-d", strtotime($date_billed_mo)) . " -1 month")));
        $number = 1;
        $soa_payments = Soapayment::where('done','0')
        ->leftJoin('clients','soapayments.client_id','=','clients.id')
        ->select('soapayments.*','clients.name as client_name','clients.lot_number as client_lot_number','clients.hoa_id as client_hoa_id','clients.address as client_address','clients.status as client_status')
        ->get();
        $payments = 0;
        foreach($soa_payments as $soa_payment){
            $soa_old = Soapayment::where('done',1)->where('client_id',$soa_payment->client_id)->orderBy('date_soa','desc')->first();
            if($soa_old == null)
            {
                $payments = 0;
            }
            else
            {
                $payment = Payment::where('soa_number',$soa_old->id)->first();
                if($payment == null)
                {
                    
                    $payments = 0;
                }
                else
                {
                    $payments = $payment->amount;
                }
            }
            $rate =  $soa_payment->rate;
            $lot_size =  $soa_payment->lot_size;
            $previous_interest = $soa_payment->previos_interest;
            $special_assessment = $soa_payment->special_assessment;
            $last_payment = $payments;
            $others = $soa_payment->others;
            $discount = $soa_payment->discount;
            $total_overdue_charges = $soa_payment->previos_bill+$soa_payment->previos_interest-$soa_payment->discount-$last_payment;
            if(($soa_payment->previos_bill - $last_payment) <= 0)
            {
                $latest_interest = 0;
            }
            else
            {
                $latest_interest = $soa_payment->previos_bill * .02;
            }
            $total_current_charges = ($soa_payment->special_assessment+$soa_payment->others+($soa_payment->rate * $soa_payment->lot_size));
            $soa_adjustment = $soa_payment->adjustment;
            $sub_total = $total_overdue_charges + $latest_interest - $soa_payment->adjustment;
            $total_amout_due = $sub_total + $total_current_charges;
            
            if($total_amout_due <= 0)
            {
                $previous_bill_total = $total_amout_due;
                $previos_interest_total = 0;
            }
            else 
            {
                $interest_total = $previous_interest + $latest_interest;
                $a = $total_amout_due - $interest_total ;

                if($a >= 0)
                {
                    $previous_bill_total = $a;
                    $previos_interest_total = $interest_total;
                   
                }
                else
                {
                    $previous_bill_total = 0;
                    $previos_interest_total = $a * -1;
                }

            }
            $soa_done = Soapayment::where('done',0)->where('client_id',$soa_payment->client_id)->first();
            $soa_done->done = 1;
            $soa_done->save();
            $client = Client::findOrFail($soa_payment->client_id);
            $data = new SoaPayment;
            $data->client_id = $client->id;
            $data->date_soa = $last_date_of_soa;
            $data->billing_number = $number;
            $data->date_billed = $date_billed;
            $data->date_due = $final;
            $data->lot_size = $client->area;
            $data->rate = 7;
            $data->discount = 0.00;
            $data->adjustment = 0.00;
            $data->special_assessment = 0.00;
            $data->others = 0.00;
            $data->remarks = ' ';
            $data->previos_bill = $previous_bill_total;
            $data->previos_interest = $previos_interest_total;
            $data->done = 0;
            $data->save();
            $number = $number + 1;
        }
        $request->session()->flash('status','Successfully Generated month of '.$month);
        return back();
    }
    public function save_edit_soa(Request $request, $id)
    {
        $data = Soapayment::findOrfail($id);
        
        $data->discount = $request->discount;
        $data->adjustment = $request->adjustment;
        $data->remarks = $request->remarks;
        $data->save();
        $request->session()->flash('status','Successfully Updated '.$request->name);
        return back();
    }
    public function add_payment(Request $request, $id)
    {
        
        $data = new Payment;
        $data->amount = $request->amount;
        $data->or_number = $request->or_number;
        $data->type = $request->type;
        $data->date_paid = $request->date_of_payment;
        $data->remarks = $request->remarks;
        $data->soa_number = $id;
        $data->add_by = auth()->user()->id;
        $data->save();
        $request->session()->flash('status','Successfully Added Payment to '.$request->name);
        return back();
    }
    public function save_edit_payment(Request $request, $id)
    {
        $data = Payment::findOrfail($id);
        $data->amount = $request->amount;
        $data->or_number = $request->or_number;
        $data->type = $request->type;
        $data->date_paid = $request->date_of_payment;
        $data->remarks = $request->remarks;
        $data->save();
        $request->session()->flash('status','Successfully Payment Updated'.$request->name);
        return back();
    }
    public function summary_report(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $type = $request->type;
        $results = [];
        if($type == 1)
        {
            $results = Payment::whereBetween('date_paid',[$date_from, $date_to])
            ->leftJoin('soapayments','payments.soa_number','=','soapayments.id')
            ->leftJoin('clients','soapayments.client_id','=','clients.id')
            ->select('payments.*','clients.name as client_name','clients.lot_number')
            ->orderBy('date_paid','asc')
            ->get();
        }
        elseif($type == 2)
        {
            $results = Careceipt::whereBetween('date',[$date_from, $date_to])->orderBy('date','asc')->get();
        }
        return view('summary_report',array(
            'date_from' => $date_from,
            'date_to' => $date_to,
            'type' => $type,  
            'ca_receipts' => $results,         
        ));
    }
    public function obr_report(Request $request)
    {
        $date_select = $request->date_select;
        $date_uses = Soapayment::groupBy('date_soa')->orderBy('date_soa','desc')->get(['date_soa']);
        $soa_payments = Soapayment::where('date_soa',$date_select)
        ->leftJoin('clients','soapayments.client_id','=','clients.id')
        ->select('soapayments.*','clients.name as client_name','clients.lot_number as client_lot_number','clients.hoa_id as client_hoa_id','clients.address as client_address','clients.status as client_status')
        ->get();
        $payments = [];

        foreach($soa_payments as $soa_payment){
            $soa_old = Soapayment::where('done',1)->where('client_id',$soa_payment->client_id)->orderBy('date_soa','desc')->first();
            if($soa_old == null)
            {
                $payments[] = 0;
            }
            else
            {
                $payment = Payment::where('soa_number',$soa_old->id)->first();
                if($payment == null)
                {
                    
                    $payments[] = 0;
                }
                else
                {
                    $payments[] = $payment->amount;
                }
            }
        }
        return view('obr_report',array(
            'date_uses' => $date_uses, 
            'date_select' => $date_select,
            'soa_payments' => $soa_payments,
            'payments' => $payments,
        ));
    }
    public function obr_report_pdf(Request $request)
    {
        $date_select = $request->date_select;
        $date_uses = Soapayment::groupBy('date_soa')->orderBy('date_soa','desc')->get(['date_soa']);
        $soa_payments = Soapayment::where('date_soa',$date_select)
        ->leftJoin('clients','soapayments.client_id','=','clients.id')
        ->select('soapayments.*','clients.name as client_name','clients.lot_number as client_lot_number','clients.hoa_id as client_hoa_id','clients.address as client_address','clients.status as client_status')
        ->get();
        $payments = [];
        foreach($soa_payments as $soa_payment){
            $soa_old = Soapayment::where('done',1)->where('client_id',$soa_payment->client_id)->orderBy('date_soa','desc')->first();
            if($soa_old == null)
            {
                $payments[] = 0;
            }
            else
            {
                $payment = Payment::where('soa_number',$soa_old->id)->first();
                if($payment == null)
                {
                    
                    $payments[] = 0;
                }
                else
                {
                    $payments[] = $payment->amount;
                }
            }
        }
        $pdf = PDF::loadView('obr_report_pdf_all',array(
            'soa_payments' => $soa_payments,
            'payments' => $payments,
            'date_select' => $date_select,
        ))->setOrientation('landscape');
        
        return $pdf->stream('soa_all_obr.pdf');

    }
    public function payment_report_pdf(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $results = Payment::whereBetween('date_paid',[$date_from, $date_to])
        ->leftJoin('soapayments','payments.soa_number','=','soapayments.id')
        ->leftJoin('clients','soapayments.client_id','=','clients.id')
        ->select('payments.*','clients.name as client_name','clients.lot_number')
        ->orderBy('date_paid','asc')
        ->get();
        $pdf = PDF::loadView('payment_report_pdf',array(
            'date_from' => $date_from,
            'date_to' => $date_to,
            'results' => $results,    

        ));
        return $pdf->stream('payment_report.pdf');

    }
}
