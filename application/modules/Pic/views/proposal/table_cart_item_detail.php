<!-- Item Acuan -->
<?php foreach ($item_cart->result() as $irc) { ?>
    <input type="hidden" data-estimation="<?= $irc->item_code ?>" value="<?= $irc->sales_estimation ?>">
<?php } ?>

<?php $no=1; for ($i = 0; $i < count($_POST['customer']); $i++) { ?>
    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header">
                    <h4><?=$no++.". ".getCustomerName($_POST['customer'][$i]) ?></h4>
                </div>
                <div class="box-body">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th style="display: none;">Item Code</th>
                                <th>Barcode</th>
                                <th>Item Name</th>
                                <th style="display:none;">Avg Sales (Qty)</th>
                                <th>Sales Estimation (Qty)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($item_cart->result() as $ir) { ?>
                                <tr>
                                    <td style="display: none;" class="td_item_code"><?= $ir->item_code ?></td>
                                    <td><?= $ir->barcode ?></td>
                                    <td><?= $ir->item_name ?></td>
                                    <td style="display:none;">
                                        <input type="number" name="qty_avg_sales" class="form-control qty_avg_sales" value="<?=get_avg_sales_qty_per_customer($ir->no_proposal,$_POST['customer'][$i],$ir->item_code)?>" readonly>
                                    </td>
                                    <td style="width:150px">
                                        <input type="hidden" class="customer_item" value="<?= $_POST['customer'][$i] ?>">
                                        <input type="hidden" class="customer_item_code" value="<?= $ir->item_code ?>">
                                        <input type="hidden" class="max_estimasi" value="<?= $ir->sales_estimation ?>" readonly>
                                        <input type="number" name="qty_estimasi_detail" onkeyup="validationEstimasi(this)" class="form-control qty_estimasi_detail" data-cic="<?= $ir->item_code ?>" value="0">
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>