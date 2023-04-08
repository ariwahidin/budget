<table id="table_customer_sct" class="table table-bordered table-striped" width="100%">
    <thead>
        <tr>
            <th>No.</th>
            <th>Customer</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        if($customer->num_rows() > 0){
            foreach($customer->result() as $data){?>
                <tr>
                    <td style="width:5%"><?=$no++?>.</td>
                    <td id="outletName"><?=$data->customer_name?></td>
                    <td class="text-center" style="width:5%;">
                        <button id="del_customer_selected" class="btn btn-xs btn-danger"
                            data-customer_id="<?=$data->customer_id?>"
                            >
                            <i class="fa fa-minus"></i>
                        </button>
                    </td>
                </tr>
        <?php }
        } else {
            echo '<tr>
                <td colspan="4" class="text-center">Tidak ada outlet</td>
            </tr>';
        } ?>
    </tbody>
</table>
<script>
    $('#table_customer_sct').DataTable({
        ordering : false,
        searching : false,
        info : false,
        scrollY: '235px',
        scrollCollapse: true,
        paging: false,
    }) 
</script>
    
    