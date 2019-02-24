<div class="modal fade" id="edit_car{{$ca_receipt->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row w-100'>
                    <div class='col-10'>
                        <h1 class="modal-title" id="exampleModalLabel">Edit Car</h1>
                    </div>
                    <div class='col-2'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                </div>
            </div>
            <form  method='POST' action='edit-car/{{$ca_receipt->id}}'  onsubmit="show()" >
                <div class="modal-body"> 
                        <div class='row w-100'>
                            {{ csrf_field() }}
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input class="form-control" pattern="[A-Za-z ,.]+" value='{{$ca_receipt->name}}' type="text" name='name' id='name' placeholder='Name'  required>
                                </div>
                            </div>
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label>Date of Payment:</label>
                                    <input class="form-control" type="date" name='date_of_payment' value='{{$ca_receipt->date}}' id='date_of_payment' required>
                                </div>
                            </div>
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label>of:</label>
                                    <input class="form-control" type="text" value='{{$ca_receipt->for_what}}' name='for_what' id='for_what' placeholder='of'  required>
                                </div>
                            </div>
                        </div>
                        <div class='row w-100'>
                            {{ csrf_field() }}
                            <div class='col-md-2'>
                                <div class="form-group">
                                    <label>Amount:</label>
                                    <input class="form-control" type="number" step='0.01' value='{{$ca_receipt->amount}}'  placeholder='0.00' name='amount' id='amount' min='0.00'  required>
                                </div>
                            </div>
                            <div class='col-md-10'>
                                <div class="form-group">
                                    <label>As Payment For:</label>
                                    <input class="form-control" type="text" name='payment_for' value='{{$ca_receipt->as_payment}}' id='payment_for' placeholder='As Payment For' required>
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