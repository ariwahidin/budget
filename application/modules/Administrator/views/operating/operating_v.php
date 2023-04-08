<!-- <?php var_dump($_SESSION) ?> -->
<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Budget Activity</h4>
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
                                    <th>Operating</th>
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
                                        <td><?= number_format($op->OperatingBudget) ?></td>
                                        <td><?= statusOperatingActivity($op->BudgetCode)?></td>
                                        <td>
                                            <a href="<?=base_url($_SESSION['page'].'/lihatOperatingActivity/'.$op->BudgetCode)?>" class="btn btn-info btn-xs">Lihat Activity</a>
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
</script>