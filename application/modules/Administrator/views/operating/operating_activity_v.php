<!-- <?php var_dump($operating_activity->result()); ?> -->
<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h4>Data Operating</h4>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <table>
                            <tr>
                                <td>Brand</td>
                                <td>&nbsp;:&nbsp;<?= getBrandName($brand); ?></td>
                            </tr>
                            <tr>
                                <td>Periode</td>
                                <td>&nbsp;:&nbsp;<?=get_periode_operating($budget_code)?></td>
                            </tr>
                        </table>
                        <?php if ($operating_activity->num_rows() == 0) { ?>
                            <a href="<?= base_url($_SESSION['page'] . '/setOperatingActivity/' . $budget_code) ?>" class="btn btn-primary pull-right">Set Activity</a>
                        <?php } ?>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table-striped table_operating">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <!-- <th>Budget Code</th> -->
                                    <th>Brand</th>
                                    <th>Activity</th>
                                    <th>Precentage (%)</th>
                                    <th>Total_Operating_Activity</th>
                                    <th>YTD_Operating_Activity</th>
                                    <th>YTD_Purchase_Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($operating_activity->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <!-- <td><?= $data->BudgetCodeActivity ?></td> -->
                                        <td><?= getBrandName($data->BrandCode) ?></td>
                                        <td><a href="<?= base_url($_SESSION['page'] . '/lihatOperatingActivityDetail/' . $data->BudgetCodeActivity) ?>"><?= getActivityName($data->ActivityCode) ?></a></td>
                                        <td><?= $data->Precentage ?></td>
                                        <td><?= number_format($data->OperatingBudget) ?></td>
                                        <td><?= number_format(get_ytd_operating_activity($data->BudgetCodeActivity)) ?></td>
                                        <td><?= number_format((float)get_ytd_purchase($data->BrandCode, $data->StartPeriode) * ($data->Precentage / 100)) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->view('footer') ?>
<script>
    $('.table_operating').dataTable();
</script>