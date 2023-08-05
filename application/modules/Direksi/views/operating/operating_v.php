<!-- <?php var_dump($operating->row()) ?> -->
<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Budget</h4>
                    </div>
                    <div class="box-body">
                        <form action="<?= base_url($_SESSION['page']) ?>/loadDetailBudget" method="POST" id="formDetailBudget">
                            <input type="hidden" id="budget_code" name="budget_code">
                        </form>
                        <table class="table table-responsive table-bordered table-striped table_operating" style="font-size:12px">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Brand</th>
                                    <th>Periode</th>
                                    <th>Target Principal</th>
                                    <th>A&P Principal</th>
                                    <th>Target PK</th>
                                    <th>A&P PK</th>
                                    <th>Operating</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($operating->result() as $op) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $op->BrandName ?></td>
                                        <td><?= date('M-Y', strtotime($op->StartPeriode)) . ' s/d ' . date('M-Y', strtotime($op->EndPeriode)) ?></td>
                                        <td><?= number_format($op->PrincipalTarget) ?></td>
                                        <td><?= number_format($op->TargetAnp) ?></td>
                                        <td><?= number_format($op->PKTarget) ?></td>
                                        <td><?= number_format($op->PKAnp) ?></td>
                                        <td><?= number_format($op->OperatingBudget) ?></td>
                                        <td>
                                            <button onclick="loadDetailBudget(this)" data-budget-code='<?= $op->BudgetCode ?>' class="btn btn-primary btn-xs">Detail</button>
                                            <!-- <a onclick="loading()" href="<?= base_url($_SESSION['page'] . '/ShowDetailBudget/' . $op->BudgetCode) ?>" class="btn btn-success btn-xs">Tracking Budget</a>
                                            <?php if (statusOperatingActivity($op->BudgetCode) == 'not complete') { ?>
                                                <a href="<?= base_url($_SESSION['page'] . '/lihatOperatingActivity/' . $op->BudgetCode) ?>" class="btn btn-info btn-xs">Breakdown Activity</a>
                                            <?php } ?> -->
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

    function loadDetailBudget(button) {
        let budgetCode = $(button).data('budget-code')
        $('#budget_code').val(budgetCode)
        $('#formDetailBudget').submit()
    }
</script>