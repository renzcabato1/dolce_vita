<div class="modal fade" id="edit_soa{{$soa_payment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row w-100'>
                    <div class='col-10'>
                        <h1 class="modal-title" id="exampleModalLabel">Edit SOA</h1>
                    </div>
                    <div class='col-2'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                </div>
            </div>
            <form  method='POST' action='edit-soa/{{$soa_payment->id}}'  onsubmit="show()" >
                <div class="modal-body"> 
                    <div class='row w-100'>
                        {{ csrf_field() }}
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Name:</label>
                                <input class="form-control" pattern="[A-Za-z ,.]+" value='{{$soa_payment->client_name}}' type="text" name='name' id='name' placeholder='Name'  readonly>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label>Discount:</label>
                            <input class="form-control" type="number"  step='0.01'  value='{{$soa_payment->discount}}' name='discount'  placeholder='111.00'  required>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label>Adjustment:</label>
                                <input class="form-control" type="number"   step='0.01'  value='{{$soa_payment->adjustment}}' name='adjustment'  placeholder='111.00'  required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-12'>
                            <div class="form-group">
                                <label>Remarks:</label>
                            <textarea name='remarks' class="form-control" required>{{$soa_payment->remarks}}</textarea>
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