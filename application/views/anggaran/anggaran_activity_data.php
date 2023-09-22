<?php
    // var_dump($anggaranActivity->num_rows());
    if($anggaranActivity->num_rows() == 0){
        echo "Activity Belum Ditambahkan";
        die;
    }
    $row = $anggaranActivity->result();
    $no_anggaran = $row[0]->no_anggaran;
?>
<?php 
    $months = [];
    $years = [];
    foreach($monthAnggaran->result() as $data){
        array_push($months, $data->month);
        array_push($years, $data->tahun);
    }
    $start_month = $months[0];
    $end_month = end($months); 
    $start_year = $years[0];
    $end_year = end($years);
?>
<style>
    thead tr th{
        /* display:table; */
        width: 130px;
        background-color: lightblue;
        /* position: fixed; */
    }
    table{
        /* table-layout:fixed; */
    }
</style>
<section class="content-header">
    <h1>
    Data Anggaran Activity
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Data Anggaran Activity</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <a href="<?=site_url('anggaran')?>">
                    <button class="btn btn-primary pull-right">
                        <i class="fa fa-rotate-left"></i> Back
                    </button>
                </a>
                <table>
                    <tr>
                        <td>No Anggaran</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=$no_anggaran?></td>
                    </tr>
                    <tr>
                        <td>Brand</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=getBrandFromBudgetActivity($no_anggaran)?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=$start_year?></td>
                    </tr>
                    <tr>
                        <td>Total Budget</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>
                            <b><?=number_format(TotalBudgetPerPeriode($no_anggaran))?></b>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="box-body">
                <table class="table table-bordered" id="tableAnggaranActivity">
                    <thead>
                        <tr>
                            <th style="background-color:white; z-index:1;">Activity</th>
                            <th style="background-color:white; z-index:1;">
                                Subtotal <br>
                                <?=number_format(subtotalAnggaranPerBrand($no_anggaran))?>
                            </th>
                            <th>
                                Presentase (%) <br>
                                <b id="totalPresentase"></b>
                            </th>
                            <?php foreach($monthAnggaran->result() as $month){?>
                            <th style="width:120px;">
                                <?=getMonth($month->month).' '.$month->tahun?><br>
                                <?=number_format(getGrandTotalActivity($no_anggaran, $month->month))?>
                            </th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($presentase->result() as $key => $value){ ?>
                        <tr>
                            <td style="background-color:white;">
                                <a href="<?=site_url('AnggaranUsed/getData/').$no_anggaran.'/'.$value->activity?>">
                                    <?=getActivityName($value->activity)?>
                                </a>
                            </td>
                            <td style="background-color:white;">
                                <b><?=number_format(getSubtotalAnggaranPerActivity($no_anggaran, $value->activity))?></b>
                            </td>
                            <td class="presentasePerActivity">
                                <?=$value->presentase?>
                            </td>
                            <?php foreach($monthAnggaran->result() as $month){?>
                                <td>
                                    <?=number_format(getDefaultNominalActivity($no_anggaran, $month->month, $value->activity))?>
                                </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</section>
<script>
    $(document).ready(function(){
        var presentasePerActivity = document.getElementsByClassName("presentasePerActivity");
        var totalPresentase = parseFloat(0);
        for(var i = 0; i < presentasePerActivity.length; i++){
            totalPresentase += parseFloat(presentasePerActivity[i].innerText);
        }
        // console.log(totalPresentase);
        document.getElementById("totalPresentase").innerText = totalPresentase;
    })
</script>
<script>
    // $('#tableAnggaranActivity').DataTable({resposive : true});
    $('#tableAnggaranActivity').DataTable({
        ordering : false,
        info : false,
        // scrollX : true,
        scrollCollapse : true,
        // paging : false,
        fixedColumns : {
            left: 2,
        }
    })
</script>