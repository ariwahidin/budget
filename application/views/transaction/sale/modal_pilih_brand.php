<div class="modal fade" id="modal-pilih-brand">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Brand</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="table_pilih_brand">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Code</th>
                            <th>Brand Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach($brand->result() as $i => $data) { ?>
                            <tr>
                                <td style="width:2%"><?=$no++?></td>
                                <td><?=$data->abbr?></td>
                                <td><?=$data->name?></td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-info" id="chose_brand"
                                    data-id_brand="<?=$data->sid?>"
                                    data-brand_name="<?=$data->name?>"
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

    $(document).on('click','#chose_brand',function(){

    $('#brand_id').val($(this).data('id_brand'))
    $('#brand_name').val($(this).data('brand_name'))
    $('#modal-pilih-brand').modal('hide')
    })

    

</script>