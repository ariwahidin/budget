<?php $no = 1;
if($outlet->num_rows() > 0){
    foreach($outlet->result() as $p => $value){?>
        <tr>
            <td style="width:5%"><?=$no++?>.</td>
            <td id="outletName"><?=$value->outlet_name?></td>
            <td class="text-center" width="160px">
                <button id="del_outlet" class="btn btn-xs btn-danger"
                    data-outlet_id="<?=$value->id_outlet?>"
                    >
                    <i class="fa fa-trash"></i> Hapus
                </button>
            </td>
        </tr>
<?php }
} else {
    echo '<tr>
        <td colspan="4" class="text-center">Tidak ada outlet</td>
    </tr>';
} ?>