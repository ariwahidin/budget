<?php 
    // var_dump($month->result()); 
    // var_dump($brand_code);
    // var_dump($year_budget);
    // var_dump($code_anggaran);
    // var_dump($anp_value->result());
    // var_dump($activity->result());
?>
<div class="row">
    <div class="col-md-12">
        <div id="main-content">
            <section class="content-header">
                <h1>
                Budget Marketing And Advertising
                </h1>
            </section>

            <section class="content">
                <div class="box">
                    <div class="box-header">
                        <table>
                            <tr>
                                <td>No Anggaran</td>
                                <td>&nbsp;:&nbsp;</td>
                                <td><?=$code_anggaran?></td>
                            </tr>
                            <tr>
                                <td>Brand</td>
                                <td>&nbsp;:&nbsp;</td>
                                <td><?=getBrandName($brand_code)?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="table_anggaran" width="">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Activity</th>
                                    <th>Budget <?='-'.$year_budget?></th>
                                    <?php foreach($month->result() as $k => $v){
                                        $s = new DateTime($v->month);
                                        $date = $s->format('M-Y');
                                        echo "<th width='90px'>".$date."</th>";
                                    } ?>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Actual Purchase</th>
                                    <th><?=number_format($sum_purchase->row()->sumActualPurchase)?></th>
                                    <?php foreach($actual_purchase->result() as $p){
                                        echo "<th>".number_format($p->actualPurchase)."</th>";
                                    } ?>
                                </tr>
                                <tr style="background-color:lightgreen;">
                                    <th></th>
                                    <th>Actual A&P (<?=$presentase_purchase->row()->presentasePurchase?>%)</th>
                                    <th><?=number_format($sum_anp->row()->totalAnp)?></th>
                                    <?php foreach($anp_value->result() as $anp){
                                        echo "<th>".number_format($anp->actualAnp)."</th>";
                                    } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($activity->result() as $data){ ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td>
                                            <?=getActivityName($data->activity)?>
                                            (<?=$data->presentaseBudget?>%)
                                        </td>
                                        <td><?=number_format(getSumBudgetActivity($code_anggaran, $data->activity))?></td>
                                        <?php foreach($month->result() as $ke => $va){
                                            $ss = new DateTime($va->month);
                                            $datex = $ss->format('Y-m-d');
                                            echo "<td>".number_format(getMonthValueBudget($brand_code,$year_budget,$data->activity,$datex,$code_anggaran))."</td>";
                                            // echo "<td>".$va->month."</td>";
                                        } ?>
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