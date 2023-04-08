<div class="modal fade" id="modal-customer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Outlet</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="table_customer">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($customer as $cust => $value) { ?>
                            <tr>
                                <td style="width:5%"><?=$value->sid?></td>
                                <td><?=$value->customer_name?></td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-info" id="select_customer"
                                    data-id="<?=$value->sid?>"
                                    data-customer="<?=$value->customer_name?>"
                                        <i class="fa fa-check"></i> Select
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // add customer yang dipilih
     $(document).on('click','#select_customer',function(){
        var customer_id = $(this).data('id')
        var nama_customer = $(this).data('customer')
        // $('#cust').val(nama_customer) 
        // $('#customer_id').val(customer_id)       
        $('#modal-customer').modal('hide')

        $.ajax({
                    type : 'POST',
                    url : '<?=site_url('sale/process')?>',
                    data : {
                            'pilih_outlet': true,
                            'outlet_id': customer_id,
                            'outlet_name': nama_customer,
                            },
                    dataType: 'json',
                    success: function(result){
                        if(result.success == true){
                            // alert('Outlet berhasil dipilih')
                            $('#table_outlet').load('<?=site_url('sale/outlet_selected_data')?>',function(){
                            
                            })
                        }else{
                            alert('Outlet yang dipilih sama, pilih outlet yang lain')
                        }

                    }
                })

        })
</script>
