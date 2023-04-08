<section class="content-header">
    <h1>
    Daftar Proposal
    </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="pull-right">
                <!-- <button id="buat_baru" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i> Buat Baru
                </button> -->
                <button id="create_new" class="btn btn-success btn-flat">
                    <i class="fa fa-plus"></i> Create New
                </button>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No Proposal</th>
                        <th>Brand</th>
                        <th>Pic</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($proposal->result() as $data){?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=$data->no_proposal?></td>
                            <td><?=$data->brand_code?></td>
                            <td><?=$data->created_by?></td>
                            <td><?=date('d-M-Y',strtotime($data->start_periode)).' s/d '.date('d-M-Y',strtotime($data->end_periode))?></td>
                            <td><?=$data->is_approve == 'y' ? 'Aprroved' : 'On Process'?></td>
                            <td>
                                <a href="<?=site_url('ProposalPromosi_C/proposalDataDetail/').$data->no_proposal?>" class="btn btn-primary btn-xs">Lihat</a>
                            </td>
                        </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<div id="show_modal_create_new"></div>
<script>
    $(document).ready(function(){
        $('#create_new').on('click', function(){
            $('#show_modal_create_new').load('<?=site_url('ProposalPromosi_C/createNewProposal')?>');
        })
    })
</script>