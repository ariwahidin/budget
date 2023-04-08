<div class="modal fade" id="modal-budget-tambahan" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Item</h4>
            </div>
            <div class="modal-body">
                <!-- <?php var_dump($months); ?> -->
                <table class="table table-bordered table-striped" id="table_budget_tambahan">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Budget</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($anggaran->num_rows() > 0){?>
                            <?php $no=1; foreach($anggaran->result() as $data){ ?>
                                <tr>
                                    <td><?=getMonth($data->month)?></td>
                                    <td><?=number_format($data->nominal)?></td>
                                    <td class="text-center">
                                        <button id="btn_budget_tambahan" 
                                        data-bulan_tambahan="<?=$data->month?>"
                                        data-month_name="<?=getMonth($data->month)?>" 
                                        data-nominal="<?=number_format($data->nominal)?>" 
                                        class="btn btn-primary">Select</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                            Tidak Ada Data
                        <?php } ?>
                    </tbody>
                </table>
                     
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#modal-budget-tambahan').modal('show');
    });
</script>