<?php
    // var_dump($anggaran->result());
?>
<style>
    .text-center{
        text-align : center !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div id="set_budget_activity"></div>
        <div id="show_modal_set_new_budget"></div>
        <div id="show_modal_set_new_budget_from_purchase"></div>
        <div id="show_modal_set_budget_activity"></div>
        <div id="main-content">
            <section class="content-header">
                <h1>
                Data Anggaran
                </h1>
                <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
                <li class="active">Anggaran</li>
                </ol>
            </section>

            <section class="content">
                <div class="box bgst">
                    <div class="box-header">
                        <!-- <h3 class="box_title">Data Anggaran</h3> -->
                        <!-- <div class="pull-right">
                            <a href="<?=site_url('pembelian')?>" class="btn btn-primary btn-flat">
                                <i class="fa fa-plus"></i> Create Budget
                            </a>
                        </div> -->
                        <div class="pull-right">
                            <button class="btn btn-success" id="set_new_budget">
                                <i class="fa fa-plus"> Create New Budget</i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="table_anggaran">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Code</th>
                                    <th>Pic</th>
                                    <th>Budget</th>
                                    <th>Purchase Date</th>
                                    <th>Brand</th>
                                    <th>Value</th>
                                    <th class="text-center" width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($anggaran->result() as $data){ 
                                    $startDate = new DateTime($data->startDatePurchase);
                                    $startDate = $startDate->format('M-Y');
                                    $endDate = new DateTime($data->endDatePurchase);
                                    $endDate = $endDate->format('M-Y');
                                    ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$data->codeAnggaran?></td>
                                        <td><?=getUserName($data->pic)?></td>
                                        <td><?=$data->budgetYear?></td>
                                        <td>
                                            <?=$startDate.' s/d '.$endDate?>
                                        </td>
                                        <td><?=getBrandName($data->brandCode)?></td>
                                        </td>
                                        <td><?=number_format($data->budgetYearValue)?></td>
                                        <td class="">
                                            <a href="<?=site_url('Anggaran_C/lihatAnggaran/').$data->brandCode.'/'.$data->budgetYear.'/'.$data->codeAnggaran?>" class="btn btn-primary">Lihat</a>
                                            <a href="<?=site_url('Anggaran_C/deleteAnggaran/').$data->codeAnggaran?>" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<div id="wadahModal">
</div>
<script>
    $('#table_anggaran').DataTable();
    $('#set_new_budget').on('click', function(){
        $('#show_modal_set_new_budget').load('<?=site_url('Anggaran_C/showModalSetNewBudget')?>')
    })
</script>