<div class="modal fade" id="generate_soa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row w-100'>
                    <div class='col-10'>
                        <h1 class="modal-title" id="exampleModalLabel">Generate SOA</h1>
                    </div>
                    <div class='col-2'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                </div>
            </div>
            <form  method='POST' action='generate-soa'  onsubmit="show()" >
                <div class="modal-body"> 
                    <div class='row w-100'>
                        {{ csrf_field() }}
                        <div class='col-md-12'>
                            <div class="form-group">
                                <label>Date:</label>
                            <input class="form-control" pattern="[A-Za-z ,.]+" type="month" min='{{$soa_last_month}}' name='month_of_soa'  placeholder=''  required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100' style='float:right;'>
                        <div class="modal-footer" >
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id='submit' class="btn btn-primary" >GENERATE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>