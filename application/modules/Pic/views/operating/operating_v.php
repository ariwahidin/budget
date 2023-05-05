<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <!-- <button onclick="testAlert()" class="btn btn-primary pull-right">Test</button> -->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Budget</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table-striped table_operating">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <!-- <th>Brand Code</th> -->
                                    <!-- <th>Budget Code</th> -->
                                    <th>Brand</th>
                                    <th>Periode</th>
                                    <th>Target</th>
                                    <th>A&P</th>
                                    <th>Operating</th>
                                    <th style="display:none">Actual Purchase</th>
                                    <th style="display:none">Actual A&P</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($operating->result() as $op) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <!-- <td><?= $op->BrandCode ?></td> -->
                                        <!-- <td><?= $op->BudgetCode ?></td> -->
                                        <td><?= $op->BrandName ?></td>
                                        <td><?= date('M-Y', strtotime($op->StartPeriode)) . ' s/d ' . date('M-Y', strtotime($op->EndPeriode)) ?></td>
                                        <td><?= number_format($op->PrincipalTarget) ?></td>
                                        <td><?= number_format($op->TargetAnp) ?></td>
                                        <td><?= number_format($op->OperatingBudget) ?></td>
                                        <td style="display:none"><?= number_format(getActualPurchase($op->BrandCode, $op->StartPeriode, $op->EndPeriode)) ?></td>
                                        <td style="display:none"><?= number_format(getActualPurchase($op->BrandCode, $op->StartPeriode, $op->EndPeriode) * (10 / 100)) ?></td>
                                        <td><?= statusOperatingActivity($op->BudgetCode) ?></td>
                                        <td>
                                            <a onclick="loading()" href="<?= base_url($_SESSION['page'] . '/ShowDetailBudget/' . $op->BudgetCode) ?>" class="btn btn-success btn-xs">Tracking Budget</a>
                                            <?php if (statusOperatingActivity($op->BudgetCode) == 'not complete') { ?>
                                                <a href="<?= base_url($_SESSION['page'] . '/lihatOperatingActivity/' . $op->BudgetCode) ?>" class="btn btn-info btn-xs">Breakdown Activity</a>
                                            <?php } ?>
                                        </td>
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

    function loading() {
        div_loading = document.getElementById('muncul_loading');
        div_loading.classList.add('loading');
    }

    function testAlert() {
        Swal.fire(
            'Good job!',
            'You clicked the button!',
            'success'
        )
    }
</script>