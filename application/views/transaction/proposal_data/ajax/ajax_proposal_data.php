<style>
    .text-center{
        text-align: center !important;
    }
</style>
<table id="laporan_data" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>No. Document</th>
            <th>Pic</th>
            <th>Brand</th>
            <th>Promo Type</th>
            <th class="text-center">Budget Type</th>
            <th>Tanggal Transaksi</th>
            <th>Periode</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody id="data_proposal">                   

    <?php if($transaksi->num_rows() > 0) {?>
    <?php $no=1; ?>
    <?php foreach($transaksi->result() as $data) {?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$data->no_doc?></td>
        <td><?=ucwords($data->pic)?></td>
        <td><?=$data->brand_name?></td>
        <td><?=$data->promo_name?></td>
        <td class="text-center"><?=$data->budget_name?></td>
        <td><?=substr($data->transaction_date,0,10)?></td>
        <td><?=$data->start_date.' - '.$data->end_date?></td>
        <td class="text-center" style="width:20%">
            <a href="<?=site_url('proposalData/getTransactionDetail/').$data->no_doc?>">
                <button id="" class="btn btn-xs btn-info">
                    <i class="fa fa-eye"></i> Lihat
                </button>
            </a>
            
            <a href="<?=site_url('proposalData/cetakProposalDetail/').$data->no_doc?>">
                <button id="" class="btn btn-xs btn-primary">
                    <i class="fa fa-print"></i> Cetak
                </button>
            </a>
            
            <?php if($this->fungsi->user_login()->id == 1){ ?>
            <a href="<?=site_url('proposalData/hapusProposal/').$data->no_doc?>">
                <button id="" class="btn btn-xs btn-danger">
                    <i class="fa fa-trash"></i> Hapus
                </button>
            </a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
    <?php }else{ ?>
        <tr>
            <td colspan="9" class="text-center">Tidak Ada Data</td>
        </tr>
    <?php } ?>

    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function(){
        $('#laporan_data').DataTable({resposive : true});
    })
</script>