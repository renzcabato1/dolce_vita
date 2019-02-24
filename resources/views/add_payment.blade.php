<div class="modal fade" id="add_payment{{$soa_payment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row w-100'>
                    <div class='col-10'>
                        <h1 class="modal-title" id="exampleModalLabel">Add Payment</h1>
                    </div>
                    <div class='col-2'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                </div>
            </div>
            <form  method='POST' action='add-payment/{{$soa_payment->id}}'  onsubmit="show()" >
                {{ csrf_field() }}
                <div class="modal-body"> 
                    <div class='row w-100'>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Name:</label>
                                <input class="form-control" pattern="[A-Za-z ,.]+" value='{{$soa_payment->client_name}}' type="text" name='name' id='name' placeholder='Name'  readonly>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label>Amount:</label>
                                <input class="form-control" type="number"  min='0.00' step='0.01'  name='amount'  placeholder='111.00'  required>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label>Or Number:</label>
                                <input class="form-control" type="text"   name='or_number'  required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label>Type:</label>
                                <select name='type' class="form-control" required>
                                    <option></option>
                                    <option value='Cash'>Cash</option>
                                    <option value='Check'>Check</option>
                                </select>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label>Date of Payment:</label>
                                <input class="form-control" type="date" name='date_of_payment'   required>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Remarks:</label>
                                <textarea name='remarks' class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-6'>
                            <div class="form-group" style='float:right;'>
                                <br>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" id='submit' class="btn btn-primary" >Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>