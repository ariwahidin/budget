<?php $no = 1;
if($cart->num_rows() > 0){
    foreach($cart->result() as $c => $data){?>

        <tr>
            <td><?=$no++?>.</td>
            <td><?=$data->brand_inisial?> - <?=$data->product_name?></td>
            <td class="text-center"><?=$data->cart_price?></td>
            <td class="text-center" id="qty_costing"><?=$data->show_sales_estimation?></td>
            <td class="text-center"><?=$data->value_discount?></td>
            <td class="text-center" id="discount_promo"><?=$data->discount_promo."%"?></td>
            <td class="text-center" id="total_costing"><?=$data->total_costing?></td>
            <td class="text-center" width="160px">
                <button id="edit_promo" data-toggle="modal" data-target="#modal-costing-edit"
                data-cartid="<?=$data->cart_id?>"
                data-barcode="<?=$data->barcode?>"
                data-product="<?=$data->product_name?>"
                data-price="<?=$data->price?>"
                data-discount="<?=$data->discount_promo?>"
                data-sales_target = "<?=$data->qty_sales_estimation?>"
                class="btn btn-xs btn-primary">
                    <i class="fa fa-pencil"></i> Edit Promo
                </button>
            </td>
        </tr>
<?php }
} else {
    echo '<tr>
        <td colspan="9" class="text-center">Tidak ada item</td>
    </tr>';
} ?>
        <tr>
            <td colspan="3"><b>Total</b></td>
            <td class="text-center" id="qty_costing"><b></b></td>
            <td></td>
            <td></td>
            <td class="text-center" id="total_costing"><b id="totalCosting"></b></td>
        </tr>