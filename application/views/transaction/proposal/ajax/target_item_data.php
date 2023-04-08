<?php if($cart->num_rows() > 0){?>

<?php 
    $no=1;
    foreach($cart->result() as $data){
?>
    <tr>
        <td>
            <?=$no++?>
        </td>
        <td>
            <?=$data->item_name?><br>
            <small><?=$data->FrgnName?></small>
        </td>
        <td>
            <input  type="text" class="form-control price" value="<?=number_format($data->item_price)?>" readonly>
        </td>
        <td>
            <input  type="number" class="form-control sales" id="sls" value="<?=$data->item_avg_sales_qty?>" readonly>
        </td>
        <td>
            <input  type="number" class="form-control qty" value="<?=$data->item_target_qty_display?>" readonly>
        </td>
        <td>
            <input class="form-control total" id="total_item_target" type="text" value="<?=number_format($data->item_target_total)?>" readonly>
        </td>
        <td>
            <input class="form-control promo" type="text" value="<?=$data->item_costing_discount?>" readonly>
        </td>
        <td>
            <input class="form-control promo_value" type="text" value="<?=number_format($data->item_costing_value)?>" readonly>
        </td>
        <td>
            <input class="form-control total_costing" type="text" value="<?=number_format($data->item_costing_total)?>" readonly>
        </td>
        <td class="text-center">
            <button id="edit_cart" class="btn btn-xs btn-primary" 
                data-cart_id="<?=$data->cart_id?>" 
                data-item_barcode="<?=$data->FrgnName?>" 
                data-item_name="<?=$data->item_name?>" 
                data-item_price="<?=$data->item_price?>" 
                data-item_sales="<?=$data->item_avg_sales_qty?>" 
                data-item_discount="<?=$data->item_costing_discount?>" 
                data-toggle="modal" 
                data-target="#modal-edit-cart">
                <i class="fa fa-pencil"></i>
            </button>
            <button id="del_cart" class="btn btn-xs btn-danger" data-cart_id="<?=$data->cart_id?>">
                <i class="fa fa-minus"></i>
            </button>
        </td>
    </tr>
<?php } ?>
<?php }else{ ?>
    <tr>
        <td class="text-center" colspan="10">
            Tidak ada data
        </td>
    </tr>
<?php } ?>

<script>
    $(document).ready(function(){
        $('.sales').prop('readonly',true)
    })
</script>