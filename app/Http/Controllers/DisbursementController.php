<?php

namespace App\Http\Controllers;
use App\Disbursement;
use Illuminate\Http\Request;

class DisbursementController extends Controller
{
    //
    public function disbursement()
    {
        $year = date('Y');
        $month = date('m');
        $disbursements = Disbursement::whereYear('check_date',$year)->whereMonth('check_date',$month)->get();
       
        return view('view_disbursement',array (
            'disbursements' => $disbursements, 
        ));
    }
    public function new_disbursement(Request $request)
    {
        $request->validate([
            'cv_number' => 'required|unique:disbursements,cv_number|max:255',
            'check_number' => 'required|unique:disbursements,check_number|max:255',
            'rplf_number' => 'required|unique:disbursements,rplf_number|max:255'
            ]);
        $data = new Disbursement;
        $data->payee = $request->payee;
        $data->check_date = $request->check_date;
        $data->particulars = $request->particulars;
        $data->cv_number = $request->cv_number;
        $data->rplf_number = $request->rplf_number;
        $data->check_number = $request->check_number;
        $data->amount = $request->amount;
        $data->reference = $request->reference;
        $data->remarks = $request->remarks;
        $data->save();
        $request->session()->flash('status','Successfully Added Disbursement');
        return back();
    }
    public function delete_disbursement(Request $request,$id)
    {
        $data = Disbursement::findOrfail($id);
        $data->delete();
        $request->session()->flash('status','Successfully Deleted');
        return back();
    }
}
