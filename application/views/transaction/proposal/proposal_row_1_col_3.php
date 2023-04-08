<div class="box box-widget">
    <div id="box-body-customer" class="box-body table-responsive">
        <table class="table table-bordered" id="table_cust">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="tbody_customer">

            </tbody>
        </table>
    </div>
    <div class="box-footer text-right">
        <div class="input-group">
            <input id="customer_id" type="hidden">
            <input type="hidden" id="cust" class="form-control" readonly>
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary" id="tampil_modal_customer">
                    <i class="fa fa-plus"> Add Customer</i>
                </button>
            </span>
        </div> 
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','#del_customer_selected',function(){
        var customer_id = $(this).data('customer_id')
        $.ajax({
            type: 'POST',
            url:'<?=site_url('proposal/process')?>',
            dataType:'json',
            data:{
                'del_customer_selected' : true,
                'customer_id': customer_id,
            },
            success: function(result){
                if(result.success == true){
                    $('#box-body-customer').load('<?=site_url('proposal/get_customer_selected')?>',function(){                            
                    
                    })
                }else{
                    alert('Gagal hapus outlet')
                }
            }
        })
    })

</script>