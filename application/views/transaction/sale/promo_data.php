<?php $no = 1;
if($promo_selected->num_rows() > 0){
    foreach($promo_selected->result() as $p => $data){?>

        <tr>
            <td><?=$no++?>.</td>
            <td class="nama_promo"><?=$data->promo_name?></td>
            <td class="text-center" width="160px">
                <button id="del_promo_selected" data-promoid="<?=$data->sid?>" class="btn btn-xs btn-danger">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </td>
        </tr>

<?php }
} else {
    echo '<tr>
        <td colspan="4" class="text-center">Tidak ada promo yang dipilih</td>
    </tr>';
} ?>