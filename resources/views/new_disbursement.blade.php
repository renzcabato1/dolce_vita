<div class="modal fade" id="new_disbursement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row w-100'>
                    <div class='col-10'>
                        <h1 class="modal-title" id="exampleModalLabel"></h1>
                    </div>
                    <div class='col-2'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                </div>
            </div>
            <form method='POST' action='add-disbursement'  enctype="multipart/form-data" onsubmit="return submit_form()">
                {{ csrf_field() }}
                <div class="modal-body"> 
                    <div class='row w-100'>
                        <style>
                            #lot_number_chosen{
                                width: 100% !important;
                            }
                            .chosen-search-input
                            {
                                width: 100% !important; 
                            }
                        </style>
                        <div class='row w-100'>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Payee: </label>
                                    <br>
                                    <input class="form-control" value='' name='payee'  required >  
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Check Date:</label>
                                    <input class="form-control" type="date" id='check_date' tabindex="4"  name='check_date'   required>
                                    <p class='error' id='date_of_payment_error'></p>
                                </div>
                            </div>
                        </div>
                        <div class='row w-100'>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Particulars: </label>
                                    <br>
                                    <input class="form-control" value='' name='particulars'  required >  
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>CV Number:</label>
                                    <input class="form-control" type="text" id='cv_number' tabindex="4"  name='cv_number'   required>
                                    <p class='error' id='date_of_payment_error'></p>
                                </div>
                            </div>
                        </div>
                        <div class='row w-100'>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>RPLF Number: </label>
                                    <br>
                                    <input class="form-control" value='' name='rplf_number'  required >  
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Check Number:</label>
                                    <input class="form-control" type="text" id='' tabindex="4"  name='check_number'   required>
                                    <p class='error' id='date_of_payment_error'></p>
                                </div>
                            </div>
                        </div>  
                        <div class='row w-100'>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Amount: </label>
                                    <br>
                                    <input class="form-control"  type="number"  min='0.00' step='0.01'  value='' name='amount'  required >  
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label>Reference:</label>
                                    <input class="form-control" type="text" id='' tabindex="4"  name='reference'   required>
                                    <p class='error' id='date_of_payment_error'></p>
                                </div>
                            </div>
                        </div>
                        <div class='row w-100'>
                                <div class='col-md-12'>
                                    <div class="form-group">
                                        <label>Remarks: </label>
                                        <br>
                                        <textarea class="form-control" value='' name='remarks'  required > </textarea>
                                    </div>
                                </div>
                                </div>
                            </div>
                        <div class='row w-100'>
                            <div class='col-md-6'>
                                <div class="form-group" style='float:right;'>
                                    <br>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" onclick='submit_form()' id='submit' class="btn btn-primary" >Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    