<?php $no = 1;
if($cart->num_rows() > 0){
    foreach($cart->result() as $c => $data){?>
        <tr>
            <td><?=$no++?>.</td>
            <td class="barcode"><?=$data->barcode?></td>
            <td id="productName"><?=$data->brand_inisial?> - <?=$data->product_name?></td>
            <td class="text-center"><?=$data->cart_price?></td>
            <td class="text-center"><?=$data->qty_last_year?></td>
            <td class="text-center" id="qty_sales"><?=$data->qty_last_3_month?></td>
            <td class="text-center" id="target_estimation"><?=$data->show_sales_estimation?></td>
            <td class="text-center" id="total_target"><?=$data->actual_value_estimation?></td>
            <td class="text-center" width="160px">
                <button id="update_cart" data-toggle="modal" data-target="#modal-item-edit"
                data-cartid="<?=$data->cart_id?>"
                data-barcode="<?=$data->barcode?>"
                data-product="<?=$data->product_name?>"
                data-price="<?=$data->cart_price?>"
                data-qty_last_year ="<?=$data->qty_last_year?>"
                data-qty_last_3_month="<?=$data->qty_last_3_month?>"
                data-multiple_estimation="<?=$data->multiple_estimation?>"
                data-qty_sales_estimation="<?=$data->qty_sales_estimation?>"
                class="btn btn-xs btn-primary"
                >
                    <i class="fa fa-pencil"></i> Update
                </button>
                <button id="del_cart" data-cartid="<?=$data->cart_id?>" class="btn btn-xs btn-danger">
                    <i class="fa fa-trash"></i> Delete
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
            <td colspan="4"><b>Total</b></td>
            <td class="text-center" id="total_target_last_year"><b></b></td>
            <td class="text-center" id="total_target_qty"><b></b></td>
            <td class="text-center" id="total_target_qty_estimation"><b></b></td>
            <td class="text-center" id="total_target_estimation"><b id="totalSalesTarget"></b></td>
            <td></td>
        </tr>