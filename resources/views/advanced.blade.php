<div class="modal fade" id="advanced" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row w-100'>
                    <div class='col-10'>
                        <h1 class="modal-title" id="exampleModalLabel">Advanced Payor</h1>
                    </div>
                    <div class='col-2'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="modal-body"> 
                
                <table id="example2"  class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Lot Number</th>
                            <th scope="col">Total Amount Due(Obr)</th>
                            <th scope="col">Payment</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($advance_payor_datas as $live_payor_data)
                            <tr>
                                <td scope="col">{{str_limit($live_payor_data['name'], 25)}}</td>
                                <td scope="col">{{$live_payor_data['lot_number']}}</td>
                                <td scope="col">{{number_format(($live_payor_data['total_amout_due']),2)}}</td>
                                <td scope="col">{{number_format(($live_payor_data['payment']),2)}}</td>
                                <td scope="col">{{number_format(($live_payor_data['soa_summary']),2)}}</td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>