<div class="modal fade" id="edit_payment{{$soa_payment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @php
                if(($soa_payment->billing_number/10) < 1 )
                {
                    $soa_number = 'SOA-'.date('Y-m',(strtotime($soa_payment->date_soa))).'-00'.$soa_payment->billing_number;
                }
                else if(($soa_payment->billing_number/10) < 10 )
                {
                    $soa_number = 'SOA-'.date('Y-m',(strtotime($soa_payment->date_soa))).'-0'.$soa_payment->billing_number;
                }
                else 
                {
                    $soa_number = 'SOA-'.date('Y-m',(strtotime($soa_payment->date_soa))).'-'.$soa_payment->billing_number;
                }
                @endphp
                <div class='row w-100'>
                    <div class='col-10'>
                        <h1 class="modal-title" id="exampleModalLabel">{{$soa_number}}</h1>
                    </div>
                    <div class='col-2'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                </div>
            </div>
            <form  method='POST' action='edit-payment/{{$soa_payment->payment_id}}'  onsubmit="show()" >
                {{ csrf_field() }}
                <div class="modal-body"> 
                    
                    <div class='row w-100'>
                        <div class='col-md-6' style=' border-right: 5px solid red;'>
                            <div class="form-group">
                                <label>Name: </label>
                                <input class="form-control" value='{{$soa_payment->client_name}}'  readonly> 
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Amount:</label>
                                <input class="form-control" type="number"  min='0.00' step='0.01' value='{{$soa_payment->payment}}'  name='amount'  placeholder='111.00'  required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-6' style=' border-right: 5px solid red;'>
                            <div class="form-group">
                                <label>Lot Number: </label>
                                <br>
                                <input class="form-control" value=' {{$soa_payment->client_lot_number}}'  readonly>  
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Or Number:</label>
                                <input class="form-control" type="text" value='{{$soa_payment->or_number}}'    name='or_number'  required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-6' style=' border-right: 5px solid red;'>
                            <div class="form-group">
                                <label>Total OBR: </label>
                                <br>
                                <input class="form-control" value='{{number_format(($data[$key]['total_amout_due']),2)}}'  readonly>  
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Type:</label>
                                <select name='type' class="form-control" required>
                                    <option>Type</option>
                                    <option {{ ($soa_payment->payment_type == 'Cash' ? "selected":"") }}  value='Cash'>Cash</option>
                                    <option {{ ($soa_payment->payment_type == 'Check' ? "selected":"") }} value='Check'>Check</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-6' style=' border-right: 5px solid red;'>
                            
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Date of Payment:</label>
                                <input class="form-control" value='{{$soa_payment->payment_date}}'  type="date" name='date_of_payment'   required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-6' style=' border-right: 5px solid red;'>
                            
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Remarks:</label>
                                <textarea name='remarks' value='' class="form-control" required>{{$soa_payment->payment_remarks}}</textarea>
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