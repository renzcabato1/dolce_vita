<?php

namespace App\Http\Controllers;
use PDF;
use App\Soapayment;
use App\Client;
use App\Obr;
use App\Payment;
use App\Careceipt;
use App\Disbursement;
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
                $payment = Payment::where('soa_number',$soa_old->id)->get();
                if(!$payment->isEmpty())
                {
                    $last_payment=0;
                    foreach($payment as $pay)
                    {
                        $last_payment = $last_payment + $pay->amount;
                    }
                    
                }
                else
                {
                    $last_payment = 0;
                }
                
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
        ->select('soapayments.*','clients.name as client_name','clients.lot_number as client_lot_number','clients.hoa_id as client_hoa_id','clients.address as client_address')
        ->get();
        
        $total_payment = 0;
        $obr = 0;
        $data=array();
        $last_payment = 0;
        $payment_a = 0;
        foreach($soa_payments as $key => $soa_payment)
        {
            $last_payment = 0;
            $payment_a = 0;
            $payment = Payment::where('soa_number',$soa_payment->id)->get();
            if(!$payment->isEmpty())
            {
                foreach($payment as $pay)
                {
                    $total_payment = $total_payment + $pay->amount;
                    $payment_a =  $payment_a  + $pay->amount;
                }
                
            }
            else
            {
                $total_payment = $total_payment;
                $payment_a = 0;
                
            }
            
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
                    $payment = Payment::where('soa_number',$soa_old->id)->get();
                    if(!$payment->isEmpty())
                    {
                        foreach($payment as $pay)
                        {
                            $last_payment = $last_payment + $pay->amount;
                        }
                        
                    }
                    else
                    {
                        $last_payment = 0;
                    }
                }
                
            }
            
            
            $total_current_charges = ($soa_payment->special_assessment+$soa_payment->others+($soa_payment->rate * $soa_payment->lot_size));
            $total_overdue_charges = $soa_payment->previos_bill+$soa_payment->previos_interest-$soa_payment->discount-$last_payment;
            if(($soa_payment->previos_bill - $last_payment) <= 0)
            {
                $latest_interest = 0;
            }
            else
            {
                $latest_interest = ($soa_payment->previos_bill - $last_payment)*.02;
            }
            // $principal = $total_overdue_charges - $soa_payment->previos_interest +$soa_payment->discount + $last_payment;
            // $interest = $total_overdue_charges - $principal - $soa_payment->adjustment + $latest_interest;
            $sub_total = $total_overdue_charges + $latest_interest - $soa_payment->adjustment ;
            $total_amout_due = $sub_total + $total_current_charges;
            $obr = $obr + $total_amout_due;
            $soa_summary = $total_amout_due - $payment_a;
            
            array_push($data,array("id" => $soa_payment->id,"total_amout_due" => $total_amout_due,"payment" => $payment_a,"soa_summary" => $soa_summary));
            
        }
        //  return ($soa_payments);
        $soa_last_month = Soapayment::orderBy('id','desc')->first();
        $name_of_month =  date(('F'),strtotime($soa_last_month->date_soa));
        return view('soa',array (
            'soa_payments' => $soa_payments,                
            'name_of_month' => $name_of_month,    
            'data' => $data,  
            'soa_last_month' => date("Y-m",(strtotime(date("Y-m", strtotime($soa_last_month->date_soa)) . " +1 month"))), 
        ));
    }
    public function print_all_soa(Request $request)
    {
        if($request->type == 1)
        {
            $soa_payments = Soapayment::where('done','0')
            ->leftJoin('clients','soapayments.client_id','=','clients.id')
            ->select('soapayments.*','clients.name as client_name','clients.lot_number as client_lot_number','clients.hoa_id as client_hoa_id','clients.address as client_address','clients.status as client_status')
            ->orderBy('client_lot_number','asc')
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
                        $payment = Payment::where('soa_number',$soa_old->id)->get();
                        if(!$payment->isEmpty())
                        {
                            $last_payment = 0;
                            foreach($payment as $pay)
                            {
                                $last_payment = $last_payment + $pay->amount;
                                
                            }
                            $payments[] = $last_payment;
                            
                        }
                        else
                        {
                            $payments[] = 0;
                        }
                        
                    }
                    
                }
            }
        }
        else if($request->type == 2)
        {
            $soa_payments = Soapayment::where('done','0')
            ->leftJoin('clients','soapayments.client_id','=','clients.id')
            ->where('clients.status','resident')
            ->select('soapayments.*','clients.name as client_name','clients.lot_number as client_lot_number','clients.hoa_id as client_hoa_id','clients.address as client_address','clients.status as client_status')
            ->orderBy('client_lot_number','asc')
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
                        $payment = Payment::where('soa_number',$soa_old->id)->get();
                        if(!$payment->isEmpty())
                        {
                            $last_payment = 0;
                            foreach($payment as $pay)
                            {
                                $last_payment = $last_payment + $pay->amount;
                                
                            }
                            $payments[] = $last_payment;
                            
                        }
                        else
                        {
                            $payments[] = 0;
                        }
                        
                    }
                    
                }
            }
            
        }
        else if($request->type == 3)
        {
            $soa_payments = Soapayment::where('done','0')
            ->leftJoin('clients','soapayments.client_id','=','clients.id')
            ->where('clients.status','non-resident')
            ->select('soapayments.*','clients.name as client_name','clients.lot_number as client_lot_number','clients.hoa_id as client_hoa_id','clients.address as client_address','clients.status as client_status')
            ->orderBy('client_lot_number','asc')
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
                        $payment = Payment::where('soa_number',$soa_old->id)->get();
                        if(!$payment->isEmpty())
                        {
                            $last_payment = 0;
                            foreach($payment as $pay)
                            {
                                $last_payment = $last_payment + $pay->amount;
                                
                            }
                            $payments[] = $last_payment;
                            
                        }
                        else
                        {
                            $payments[] = 0;
                        }
                        
                    }
                    
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
            $payments = 0;
            $soa_old = Soapayment::where('done',1)->where('client_id',$soa_payment->client_id)->orderBy('date_soa','desc')->first();
            if($soa_old == null)
            {
                $payments = 0;
            }
            else
            {
                
                $payment = Payment::where('soa_number',$soa_old->id)->get();
                if(!$payment->isEmpty())
                {
                    foreach($payment as $pay)
                    {
                        $payments = $payments + $pay->amount;
                    }
                    
                }
                else
                {
                    $payments = 0;
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
                $latest_interest = ($soa_payment->previos_bill - $last_payment) * .02;
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
                $interest_total = $previous_interest + $latest_interest - $soa_payment->adjustment ;
                $a = $total_amout_due - $interest_total;
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
        
        $request->validate([
            'or_number' => 'required|unique:payments,or_number|max:255'
            ]);
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
        $request->validate([
            'or_number' => 'required|unique:payments,or_number,'. $id,
            ]);
            
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
        elseif($type == 3)
        {
            $results = Disbursement::whereBetween('check_date',[$date_from, $date_to])->orderBy('check_date','asc')->get();
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
        ->orderBy('client_lot_number')
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
                    $payment = Payment::where('soa_number',$soa_old->id)->get();
                    if(!$payment->isEmpty())
                    {
                        $last_payment = 0;
                        foreach($payment as $pay)
                        {
                            $last_payment = $last_payment + $pay->amount;
                            
                        }
                        $payments[] = $last_payment;
                        
                    }
                    else
                    {
                        $payments[] = 0;
                    }
                    
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
    ->select('soapayments.*','clients.name as client_name'
    ,'clients.lot_number as client_lot_number','clients.hoa_id as client_hoa_id','clients.address as client_address','clients.status as client_status')
    ->orderBy('client_lot_number')
    ->get();
    $payments = [];
    $resident_count = Client::where('status','resident')->count();
    $non_resident_count = Client::where('status','non-resident')->count();
    $unknown = Client::where('status','!=','non-resident')->where('status','!=','resident')->count();
    
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
                $payment = Payment::where('soa_number',$soa_old->id)->get();
                if(!$payment->isEmpty())
                {
                    $last_payment = 0;
                    foreach($payment as $pay)
                    {
                        $last_payment = $last_payment + $pay->amount;
                        
                    }
                    $payments[] = $last_payment;
                    
                }
                else
                {
                    $payments[] = 0;
                }
                
            }
            
        }
    }
    $pdf = PDF::loadView('obr_report_pdf_all',array(
    'soa_payments' => $soa_payments,
    'payments' => $payments,
    'date_select' => $date_select,
    'resident_count' => $resident_count,
    'non_resident_count' => $non_resident_count,
    'unknown' => $unknown))->setOrientation('landscape');

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
    public function disbursement_report(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $results = Disbursement::whereBetween('check_date',[$date_from, $date_to])->orderBy('check_date','asc')->get(); 
        $pdf = PDF::loadView('disbursement_report_pdf',array(
            'date_from' => $date_from,
            'date_to' => $date_to,
            'results' => $results,
        ));
        return $pdf->stream('disbursement_report_pdf.pdf');
    }
    public function payment_show()
    {   
        
        $soapayments_id = Soapayment::where('done','=','0')->pluck('id')->toArray();
        $payments = Payment::whereIn('soa_number',$soapayments_id)
        ->leftJoin('soapayments','payments.soa_number','=','soapayments.id')
        ->leftJoin('clients','soapayments.client_id','=','clients.id')
        ->select('clients.*','payments.*','clients.id as client_id')
        ->get();
        $or_numbers = Payment::pluck('or_number')->toArray();
        $clients = Client::orderBy('name','asc')->get();
        return view('view_payment',array (
            'payments' => $payments, 
            'clients' => $clients, 
            'or_numbers' => $or_numbers, 
        ));
    }
    public function client_view_infor(Request $request)
    {
        $client = Client::findORfail($request->lot_number_id);
        
        return $client;
    }
    public function new_payment(Request $request)
    {
        $request->validate([
        'or_number' => 'required|unique:payments,or_number|max:255'
        ]);
        
        dd($request->all());
        $soa_payment = Soapayment::where('client_id',$request->lot_number)->where('done',0)->first();
        $data = new Payment;
        $data->amount = $request->amount;
        $data->or_number = $request->or_number;
        $data->type = $request->type;
        $data->date_paid = $request->date_of_payment;
        $data->remarks = $request->remarks;
        $data->soa_number = $soa_payment->id;
        $data->add_by = auth()->user()->id;
        $data->save();
        $request->session()->flash('status','Successfully Added Payment');
        return back();
    }
    public function delete_payment(Request $request, $payment_id)
    {
        $payment = Payment::find($payment_id);    
        $payment->delete();
        $request->session()->flash('status',' Successfully Deleted!');
        return back();
    }
    public function disbursement_report_a_b(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $check_type = $request->check_type;
        $results = Disbursement::whereBetween('check_date',[$date_from, $date_to])->where('check_type','=',$check_type)->orderBy('check_date','asc')->get(); 
        $pdf = PDF::loadView('disbursement_report_a_b_pdf',array(
            'date_from' => $date_from,
            'date_to' => $date_to,
            'results' => $results,
            'check_type' => $check_type,
        ));
        return $pdf->stream('disbursement_report_a_pdf.pdf');
        
    }
}
    