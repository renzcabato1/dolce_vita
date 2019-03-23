<?php

namespace App\Http\Controllers;
use App\Careceipt;
use App\User;
use Illuminate\Http\Request;      
use PDF;   
use NumberToWords\NumberToWords;
class CareceiptController extends Controller
{
    //
    public function view_ca_receipt()
    {
        $date_today = date('Y-m-d');
        $ca_receipts = Careceipt::where('created_at','>=',$date_today)->orderBy('ca_number','desc')->get();
        return view('ca_receipt',array (
            'ca_receipts' => $ca_receipts,                    
        ));
    }
    public function new_car(Request $request)
    {
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        $this->validate(request(),[
            'name' => 'required|string|max:255|',
            'date_of_payment' => 'required|date',
            'for_what' => 'required',
            'amount' => 'required',
            'payment_for' => 'required',
            ]    
        );
        $date_today = date('Y-m');
        $receipt_number = Careceipt::orderBy('id','desc')->first();
        if($receipt_number == null)
        {
            $data = new Careceipt;
            $data->name = $request->name;
            $data->date = $request->date_of_payment;
            $data->as_payment = $request->payment_for;
            $data->amount = $request->amount;
            $data->for_what = $request->for_what;
            $data->amount_word = $numberTransformer->toWords($request->amount);
            $data->ca_number = 1;
            $data->add_by = auth()->user()->id;
            $data->save();
            if(($data->ca_number/10) < 1 )
            {
                $car_number = $date_today.'-00'.$data->ca_number;
            }
            else if(($data->ca_number/10) < 10 )
            {
                $car_number = $date_today.'-0'.$data->ca_number;
            }
            else 
            {
                $car_number = $date_today.'-'.$data->ca_number;
            }
            
            $request->session()->flash('status','New CAR Added -> '.$car_number);
            return back();
        }
        else 
        {
            if($date_today == date('Y-m',(strtotime($receipt_number->created_at))))
            {
                $data = new Careceipt;
                $data->name = $request->name;
                $data->date = $request->date_of_payment;
                $data->as_payment = $request->payment_for;
                $data->amount = $request->amount;
                $data->for_what = $request->for_what;
                $data->amount_word = $numberTransformer->toWords($request->amount);
                $data->ca_number =  $receipt_number->ca_number + 1;
                $data->add_by = auth()->user()->id;
                $data->save();
                if(($data->ca_number/10) < 1 )
                {
                    $car_number = $date_today.'-00'.$data->ca_number;
                }
                else if(($data->ca_number/10) < 10 )
                {
                    $car_number = $date_today.'-0'.$data->ca_number;
                }
                else 
                {
                    $car_number = $date_today.'-'.$data->ca_number;
                }
                
                $request->session()->flash('status','New CAR Added -> '.$car_number);
                return back();
                
                
            }
            else
            {
                $data = new Careceipt;
                $data->name = $request->name;
                $data->date = $request->date_of_payment;
                $data->as_payment = $request->payment_for;
                $data->amount = $request->amount;
                $data->for_what = $request->for_what;
                $data->amount_word = $numberTransformer->toWords($request->amount);
                $data->ca_number = 1;
                $data->add_by = auth()->user()->id;
                $data->save();
                if(($data->ca_number/10) < 1 )
                {
                    $car_number = $date_today.'-00'.$data->ca_number;
                }
                else if(($data->ca_number/10) < 10 )
                {
                    $car_number = $date_today.'-0'.$data->ca_number;
                }
                else 
                {
                    $car_number = $date_today.'-'.$data->ca_number;
                }
                
                $request->session()->flash('status','New CAR Added -> '.$car_number);
                return back();
                
            }
            
        }
    }
    public function save_edit_car(Request $request,$id)
    {
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        $this->validate(request(),[
            'name' => 'required|string|max:255|',
            'date_of_payment' => 'required|date',
            'for_what' => 'required',
            'amount' => 'required',
            'payment_for' => 'required',
            ]    
        );
       
        
        $data = Careceipt::findOrfail($id);
        $data->name = $request->name;
        $data->date = $request->date_of_payment;
        $data->as_payment = $request->payment_for;
        $data->amount = $request->amount;
        $data->for_what = $request->for_what;
        $data->amount_word = $numberTransformer->toWords($request->amount);
        $data->add_by = auth()->user()->id;
        $date_today =  date('Y-m',(strtotime($data->created_at)));
        $data->save();

        if(($data->ca_number/10) < 1 )
        {
            $car_number = $date_today.'-00'.$data->ca_number;
        }
        else if(($data->ca_number/10) < 10 )
        {
            $car_number = $date_today.'-0'.$data->ca_number;
        }
        else 
        {
            $car_number = $date_today.'-'.$data->ca_number;
        }
        
        $request->session()->flash('status','Successfully Updated '.$car_number);
        return back();
        
        
    }
    public function car_pdf($id)
    {
        $careceipt = Careceipt::findOrfail($id);
        $name_by = User::findOrfail($careceipt->add_by);
        $pdf = PDF::loadView('view_car_pdf',array(
         'careceipt' => $careceipt,
         'name_by' => $name_by,
        
        ))->setPaper('letter', 'landscape');
        return $pdf->stream('soa.pdf','L
        
        
        ');
    }
}                    