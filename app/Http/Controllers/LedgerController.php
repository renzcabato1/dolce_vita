<?php

namespace App\Http\Controllers;
use App\Soapayment;
use App\Payment;
use App\Client;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    //
    public function view_ledger(Request $request)
    {
        $client_id = $request->name;
        $clients = Client::orderBy('name','asc')->get();
        $soapayment = [];
        $data = [];
        if($request)
        {
        $client = Client::findOrfail($client_id);
        $soapayment = Soapayment::where('client_id',$client_id)->orderBy('id','asc')->get();
            foreach($soapayment as $soa)
            {
                $payment = Payment::where('soa_number',$soa->id)->sum('amount');
                if($payment == null)
                {
                    $payment = 0;
                }
                array_push($data,array("id" => $soa->id,"payment" => $payment));
            }
        }
        return view('view_ledger',array(
            'clients' => $clients,
            'cl' => $client,
            'client_id' => $client_id,
            'soapayment' => $soapayment,
            'data' => $data,
            

        ));
    }
}
