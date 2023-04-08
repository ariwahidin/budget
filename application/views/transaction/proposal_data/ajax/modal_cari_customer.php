<div class="modal fade" id="modal-cari_customer" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Customer</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-responsive" id="table_cari_customer">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Code Customer</th>
                            <th>Customer Name</th>
                            <th>Brand</th>
                            <th>Tahun</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($customer->result() as $data) {?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=$data->CardCode?></td>
                            <td><?=$data->CardName?></td>
                            <td><?=$data->BRAND?></td>
                            <td><?=$data->Year?></td>
                            <td class="text-center">
                                <button id="add_customer" class="btn btn-primary" 
                                data-card_code="<?=$data->CardCode?>"
                                data-card_name="<?=$data->CardName?>">
                                    Select
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

    $(document).ready(function(){
        $('#modal-cari_customer').modal('show');
        $('#table_cari_customer').DataTable();
    })

    $(document).on('click','#add_customer', function(){
        var CustomerName = $(this).data('card_name');
        var CustomerCode = $(this).data('card_code');
        $('#CustomerName').val(CustomerName);
        $('#customer_code').val(CustomerCode);
        $('#modal-cari_customer').modal('hide');
    })
    
</script>