<div class="modal fade" id="edit_payment_new{{$payment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <form method='POST' action='edit_payment_new/{{$payment->id}}'  enctype="multipart/form-data" onsubmit="return submit_form()">
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
                        <div class='col-md-6' style=' border-right: 5px solid red;'>
                            <div class="form-group">
                                <label>Lot Number: </label>
                                <br>
                                <select data-placeholder="Choose Lot Owner" style='height:40px;' onchange='view_obr()' class="chosen-select form-control" name='lot_number' id='lot_number' >  
                                    <option></option>
                                    @foreach($clients as $client)
                                    <option value='{{$client->id}}' {{ ($client->id == $payment->client_id ? "selected":"") }}>{{$client->name}} / {{$client->lot_number}}</option>
                                    @endforeach
                                </select>
                                <p class='error' id='lot_number_error'></p>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Amount:</label>
                                <input class="form-control" type="number" value='{{$payment->amount}}' min='0.00' step='0.01' id='amount'  name='amount'  placeholder='Amount' tabindex="1"  required>
                                <p class='error' id='amount_error'></p>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-6' style=' border-right: 5px solid red;'>
                            <div class="form-group">
                                <label>Name: </label>
                            <input class="form-control" value='{{$payment->name}}'  id='name'   readonly> 
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Or Number:</label>
                                <input class="form-control" type="text" tabindex="2" id='or_number' value='{{$payment->or_number}}''  name='or_number'  required>
                                <p class='error' id='or_number_error'></p>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-6' style=' border-right: 5px solid red;'>
                            <div class="form-group">
                                <label>HOA ID: </label>
                                <br>
                                <input class="form-control" value='{{$payment->hoa_id}}'  id='hoa_id' readonly>  
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Type:</label>
                                <select name='type' tabindex="3" id='type' class="form-control" required>
                                    <option></option>
                                    <option value='Cash' {{ ($payment->type == 'Cash' ? "selected":"") }}>Cash</option>
                                    <option value='Check' {{ ($payment->type == 'Check' ? "selected":"") }}>Check</option>
                                </select>
                                <p class='error' id='type_error'></p>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-6' style=' border-right: 5px solid red;'>
                            <div class="form-group">
                                <label>Area: </label>
                                <br>
                            <input class="form-control" value='{{$payment->area}}'  id='area' readonly>  
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Date of Payment:</label>
                                <input class="form-control" type="date" id='date_of_payment' tabindex="4"  value='{{$payment->date_paid}}'   name='date_of_payment'   required>
                                <p class='error' id='date_of_payment_error'></p>
                            </div>
                        </div>
                    </div>
                    @foreach($or_numbers as $or_number)
                    <input type='hidden' name='or_numbers[]' value='{{$or_number}}' id='or_numbers'>
                    @endforeach
                    <div class='row w-100'>
                        <div class='col-md-6' style=' border-right: 5px solid red;'>
                            <div class="form-group">
                                <label>Lot Number: </label>
                                <br>
                            <input class="form-control" value='{{$payment->lot_number}}' id='lot_number_data' readonly>  
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Remarks:</label>
                            <textarea name='remarks' tabindex="5"  id='remarks' class="form-control" required>{{$payment->remarks}}</textarea>
                                <p class='error' id='remarks_error'></p>
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
<script type="text/javascript">
    function view_obr()
    {
        var lot_number_id = document.getElementById("lot_number").value;
        $('#name').empty();
        $('#hoa_id').empty();
        $('#area').empty();
        $('#lot_number_data').empty();
        document.getElementById("myDiv").style.display="block";
        $.ajax({    //create an ajax request to load_page.php
            
            type: "GET",
            url: "{{ url('/get-client-infor/') }}",            
            data: {
                "lot_number_id" : lot_number_id,
            }     ,
            dataType: "json",   //expect html to be returned
            success: function(data){    
                document.getElementById("myDiv").style.display="none";
                document.getElementById("name").value = data.name;
                document.getElementById("hoa_id").value = data.hoa_id;
                document.getElementById("area").value = data.area;
                document.getElementById("lot_number_data").value = data.lot_number;
                
            },
            error: function(e)
            {
                alert(e);
            }
            
        });
    }
    
    function submit_form()
    {
       
        var or_number_mo = document.getElementsByName('or_numbers[]');
        for (var i = 0; i <or_number_mo.length; i++) {
            var or_number_m=or_number_mo[i];
            if (or_number_m.value == document.getElementById('or_number').value){
                document.getElementById('or_number_error').innerHTML = "This Or Number already existed!";
                return false;
            }
            else
            {
                document.getElementById('or_number_error').innerHTML = "";
            }
            }
        if(document.getElementById('lot_number').value.length==0)
        { 
            document.getElementById('lot_number_error').innerHTML = "This Field is Required";
            return false;
        }
        else 
        {
            document.getElementById('lot_number_error').innerHTML = "";
        }
        if(document.getElementById('amount').value.length==0)
        { 
            document.getElementById('amount_error').innerHTML = "This Field is Required";
            return false;
        }
        else 
        {
            document.getElementById('amount_error').innerHTML = "";
        }
        if(document.getElementById('name').value.length==0)
        { 
            document.getElementById('lot_number_error').innerHTML = "This Field is Required";
            return false;
        }
        else 
        {
            document.getElementById('lot_number_error').innerHTML = "";
        }
        
        if(document.getElementById('or_number').value.length==0)
        { 
            document.getElementById('or_number_error').innerHTML = "This Field is Required";
            return false;            
        }
        else 
        {
            document.getElementById('or_number_error').innerHTML = "";
        }
        if(document.getElementById('date_of_payment').value.length==0)
        { 
            document.getElementById('date_of_payment_error').innerHTML = "Please select Date";
            return false;
            
        }
        else 
        {
            document.getElementById('date_of_payment_error').innerHTML = "";
        }
        if(document.getElementById('type').value.length==0)
        { 
            document.getElementById('type_error').innerHTML = "This Field is Required";
            return false;
            
        }
        else 
        {
            document.getElementById('type_error').innerHTML = "";
        }
        if(document.getElementById('remarks').value.length==0)
        { 
            document.getElementById('remarks_error').innerHTML = "This Field is Required";
            return false;
            
        }
        else 
        {
            document.getElementById('remarks_error').innerHTML = "";
        }
        
        if((document.getElementById('lot_number').value.length==0)||(document.getElementById('remarks').value.length==0)||(document.getElementById('type').value.length==0)||(document.getElementById('date_of_payment').value.length==0)||(document.getElementById('or_number').value.length==0))
        {
            
            return false;
        }
        else{
            document.getElementById("myDiv").style.display="block";
            return true;
        }
        
    }
</script>