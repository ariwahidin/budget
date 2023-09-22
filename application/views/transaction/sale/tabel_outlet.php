<div class="col-lg-4">
    <div class="box box-widget">
        <div class="box-body table-responsive">
            <table id="table_outlet1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Group/Outlet</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="table_outlet">
                    <?php $this->view('transaction/sale/outlet_data') ?>
                </tbody>
            </table>
        </div> 
    </div>   
</div>

<script type="text/javascript">
    $(document).on('click','#del_outlet',function(){
        // if(confirm('Apakah Anda yakin?')){
            var outlet_id = $(this).data('outlet_id')
            $.ajax({
                type: 'POST',
                url:'<?=site_url('sale/outlet_del')?>',
                dataType:'json',
                data:{'outlet_id':outlet_id},
                success: function(result){
                    if(result.success == true){
                        $('#table_outlet').load('<?=site_url('sale/outlet_selected_data')?>',function(){                            
                            
                                // $('#table_outlet1').DataTable({resposive : true})
                            
                        }) 
                        // alert('Outlet berhasil dihapus')
                    }else{
                        alert('Gagal hapus outlet')
                    }
                }
            })
        // }
    })

   
</script>