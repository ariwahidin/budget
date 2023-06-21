<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header">
                <h4>Set Detail</h4>
            </div>
            <div class="box-body">
                <table class="table table-responsive table-bordered table_detail_target" id="table_detail_target">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>GroupName</th>
                            <th>Barcode</th>
                            <th>ItemName</th>
                            <th>Sales</th>
                            <th>Target (Qty)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($sales_detail->result() as $data) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->GroupName ?></td>
                                <td><?= $data->Barcode ?></td>
                                <td><?= $data->ItemName ?></td>
                                <td><?= number_format($data->Qty) ?></td>
                                <td style="width: 100px;">
                                    <input type="number" class="form-control t_target" onkeyup="hitungEstimasi(this)" data-item-code="<?= $data->ItemCode?>" value="0">
                                    <input type="hidden" class="form-control t_group" value="<?= $data->GroupCode?>" readonly>
                                    <input type="hidden" class="form-control t_item" value="<?= $data->ItemCode?>" readonly>
                                    <input type="hidden" class="form-control t_qty" value="<?= $data->Qty ?>" readonly>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>