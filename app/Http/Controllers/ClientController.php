<?php

namespace App\Http\Controllers;
use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function clients_view()
    {
        $clients = Client::orderBy('name','asc')->get();
        return view('hmo',array (
            'clients' => $clients,
        ));
    }
    public function new_client(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|string|max:255|',
            'address' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'lot_number' => 'required|string|max:255',
            'hoa_id' => 'required|string|max:255',
            'start_date' => 'required|date|max:255',
            'area' => 'required|',
            'project_name' => 'required|',
            ]    
        );
        $data = new Client;
        $data->name = $request->name;
        $data->lot_number = $request->lot_number;
        $data->hoa_id = $request->hoa_id;
        $data->address = $request->address;
        $data->project_name = $request->project_name;
        $data->status = $request->status;
        $data->area = $request->area;
        $data->add_by = auth()->user()->id;
        $data->start_month = $request->start_date.'-01';
        $data->save();
        $request->session()->flash('status','New HMO Added -> '.$data->names);
        return back();
    }
    public function edit_client(Request $request,$id)
    {
        $this->validate(request(),[
            'name' => 'required|string|max:255|',
            'status' => 'required|string|max:255',
            'lot_number' => 'required|string|max:255',
            'hoa_id' => 'required|string|max:255',
            'start_date' => 'required|date|max:255',
            'area' => 'required|',
            'project_name' => 'required|',
            ]    
        );
        $data = Client::findorfail($id);
        $data->name = $request->name;
        $data->lot_number = $request->lot_number;
        $data->hoa_id = $request->hoa_id;
        $data->address = $request->address;
        $data->project_name = $request->project_name;
        $data->status = $request->status;
        $data->area = $request->area;
        $data->add_by = auth()->user()->id;
        $data->start_month = $request->start_date.'-01';
        $data->save();
        $request->session()->flash('status','Successfully Updated'.$data->names);
        return back();
    }
}
