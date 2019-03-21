<?php

namespace App\Http\Controllers;
use App\User;
use App\Client;
use App\Careceipt;
use App\Soapayment;
use App\Payment;
use Illuminate\Http\Request;
use Auth;
class UserController extends Controller
{
    //
    public function view_profile()
    {
        return view('profile');
    }
    public function change_password(Request $request)
    {
        $this->validate(request(),[
            'password' => 'required|min:8|confirmed',
            ]    
        ); 
        $data =  User::find(auth()->user()->id);
        $data->password = bcrypt($request->input('password'));
        $data->save();
        $request->session()->flash('status','Your Password Successfully Changed!');
        return back();
    }
    public function login()
    {
        if (!Auth::user())
        {
            return view('auth.login');
        }
        else
        {
            $total_payment = 0;
            $obr = 0;
            $live_payor = 0;
            $un_paid = 0;
            $advance_payor = 0;
            $date_today = date('Y-m-d');
            $clients_count = Client::count();
            $receipts_count = Careceipt::where('created_at','>=',$date_today)->count();
            $soa_payments = Soapayment::where('done','0')
            ->leftJoin('clients','soapayments.client_id','=','clients.id') 
            ->select('soapayments.*','clients.name','clients.lot_number')
            ->get();
            $advance_payor_data=array();
            $un_paid_data=array();
            $live_payor_data=array();
            foreach($soa_payments as $key => $soa_payment)
            {
               
              
                $payment = Payment::where('soa_number',$soa_payment->id)->first();
                if($payment == null)
                {
                    $total_payment = $total_payment;
                    $payment_a = 0;
                }
                else
                {
                    $total_payment = $total_payment + $payment->amount;
                    $payment_a = $payment->amount;
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
                        $last_payment = $payment->amount;
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
                    $latest_interest = $soa_payment->previos_bill*.02;
                }
                
                $sub_total = $total_overdue_charges + $latest_interest - $soa_payment->adjustment;
                $total_amout_due = $sub_total + $total_current_charges;
                $obr = $obr + $total_amout_due;
                $soa_summary = $total_amout_due - $payment_a;
                if($soa_summary == 0)
                {
                    $live_payor = $live_payor + 1 ;
                    array_push($live_payor_data,array("name" => $soa_payment->name,"lot_number" => $soa_payment->lot_number,"total_amout_due" => $total_amout_due,"payment" => $payment_a,"soa_summary" => $soa_summary));
          
                }
                else if($soa_summary < 0)
                {
                    $advance_payor = $advance_payor + 1;
                    array_push($advance_payor_data,array("name" => $soa_payment->name,"lot_number" => $soa_payment->lot_number,"total_amout_due" => $total_amout_due,"payment" => $payment_a,"soa_summary" => $soa_summary));
          
                } 
                else if($soa_summary > 0)
                {
                    $un_paid = $un_paid + 1 ;
                    array_push($un_paid_data,array("name" => $soa_payment->name,"lot_number" => $soa_payment->lot_number,"total_amout_due" => $total_amout_due,"payment" => $payment_a,"soa_summary" => $soa_summary));
          
                  
                }
             }
            $soa_last_month = Soapayment::orderBy('id','desc')->first();
            $name_of_month =  date(('F'),strtotime($soa_last_month->date_soa));
            return view('home',array(
                'clients_count' => $clients_count,
                'receipts_count' => $receipts_count,
                'name_of_month' => $name_of_month,
                'total_payment' => $total_payment,
                'obr' => $obr,
                'live_payor' => $live_payor,
                'un_paid' => $un_paid,
                'advance_payor' => $advance_payor,
                'live_payor_datas' => $live_payor_data,
                'un_paid_datas' => $un_paid_data,
                'advance_payor_datas' => $advance_payor_data,
                
                
            ));
        }
    }
    public function view_users()
    {
        $users = User::where('id','!=',auth()->user()->id)->orderBy('name','asc')->get();
        return view('user_accounts',array(
            'users' => $users
        ));
    }
    public function new_user(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            ]    
        );
        $data = new User;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->role = 1;
        $data->password = bcrypt($request->password);
        $data->save();
        $request->session()->flash('status',$data->email . ' successfully registered ');
        return back();
    }
}
