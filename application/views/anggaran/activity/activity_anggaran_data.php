<?php 
    // var_dump($budget_used->result());
?>
<section class="content-header">
    <h1>
    Data Pemakaian Anggaran <b><?=getActivityName($activity)?></b>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Data Pemakaian Anggaran Activity</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <table class="table table-bordered" id="table_detail_pemakaian">
                        <thead>
                            <tr>
                                <th style="width:5%;">No.</th>
                                <th>No Proposal</th>
                                <th>Bulan</th>
                                <th>Anggaran</th>
                                <th>Anggaran Terpakai</th>
                                <th>Sisa Anggaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($budget_used->result() as $data){ ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$data->no_proposal?></td>
                                <td><?=getMonth($data->month_budget)?></td>
                                <td><?=number_format($data->month_budget_value)?></td>
                                <td><?=number_format($data->budget_used)?></td>
                                <td><?=number_format($data->sisa_budget)?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="muncul_modal_anggaran_pemakaian_activity">

</div>
<script type="text/javascript">
    $(document).ready(function(){

        $('#table_detail_pemakaian').DataTable({resposive : true});

        $(document).on('click','#btn_muncul_modal_pemakaian_anggaran_activity', function(){
            var no_proposal = $(this).data('no_proposal'); 
            $('#muncul_modal_anggaran_pemakaian_activity').load('<?=site_url("AnggaranUsed/getPemakaianAnggaranActivity")?>', {no_proposal});
        })
    })
</script>