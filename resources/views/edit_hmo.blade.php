<div class="modal fade" id="edit_hmo{{$client->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row w-100'>
                    <div class='col-10'>
                        <h1 class="modal-title" id="exampleModalLabel">Edit HOA</h1>
                    </div>
                    <div class='col-2'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                </div>
            </div>
        <form  method='POST' action='edit-hmo/{{$client->id}}'  onsubmit="show()" >
                <div class="modal-body"> 
                    <div class='row w-100'>
                        {{ csrf_field() }}
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Name:</label>
                            <input class="form-control" pattern="[A-Za-z ,.]+" value='{{$client->name}}' type="text" name='name' id='name' placeholder='Name'  required>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label>Lot Number:</label>
                                <input class="form-control" type="text" value='{{$client->lot_number}}' name='lot_number' id='lot_number' placeholder='Lot Number'  required>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label>HOA ID:</label>
                                <input class="form-control" type="text" value='{{$client->hoa_id}}' name='hoa_id' id='hoa_id' placeholder='HOA ID'  required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        {{ csrf_field() }}
                        <div class='col-md-2'>
                            <div class="form-group">
                                <label>Area:</label>
                                <input class="form-control" value='{{$client->area}}' type="number"  value='{{$client->area}}'  name='area' id='area' placeholder='AREA' min='0'  required>
                            </div>
                        </div>
                        <div class='col-md-10'>
                            <div class="form-group">
                                <label>Address:</label>
                                <input class="form-control" type="text"  value='{{$client->address}}'  name='address' id='address' placeholder='Address' >
                            </div>
                        </div>
                        
                    </div>
                    <div class='row w-100'>
                        {{ csrf_field() }}
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label>Status:</label>
                                <select class="form-control" name='status' id='status' required>
                                    <option></option>
                                    <option {{ ($client->status == 'resident' ? "selected":"") }} value='resident'>Resident</option>
                                    <option {{ ($client->status == 'non-resident' ? "selected":"") }} value='non-resident'>Non-resident</option>
                                </select>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class="form-group">
                                <label>HOA Start Dues:</label>
                            <input class="form-control"   value='{{date('Y-m', strtotime($client->start_month))}}' type="month" name='start_date' id='start_date' placeholder='YYYY-MM' >
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label>Project Name:</label>
                                <input class="form-control" type="text" value='{{$client->project_name}}' name='project_name' id='project_name' placeholder='Project Name'  required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100' style='float:right;'>
                        <div class="modal-footer" >
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id='submit' class="btn btn-primary" >Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>