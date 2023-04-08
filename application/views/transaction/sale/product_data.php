<?php $no = 1;
if($product->num_rows() > 0){
    foreach($product->result() as $p => $produk){?>
        <tr>
            <td style="width:5%"><?=$no++?>.</td>
            <td><?=$produk->brand_name?></td>
            <td><?=$produk->barcode?></td>
            <td><?=$produk->product_name?></td>
            <td><?=$produk->price?></td>
            <td class="text-center" width="160px">
                <button id="pilih_product" class="btn btn-xs btn-primary"
                    data-product_id="<?=$produk->id_product?>"
                    data-product_barcode="<?=$produk->barcode?>"
                    data-product_name="<?=$produk->product_name?>"
                    data-product_price="<?=$produk->price?>"
                    >
                    <i class="fa fa-pencil"></i> Select
                </button>
            </td>
        </tr>
<?php }
} else {
    echo '<tr>
        <td colspan="6" class="text-center">Tidak ada item, Silahkan pilih brand terlebih dahulu</td>
    </tr>';
} ?>