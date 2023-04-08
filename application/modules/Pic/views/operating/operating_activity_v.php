<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h4>Budget Activity</h4>
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
                                <td>&nbsp;:&nbsp;<?= get_periode_operating($budget_code) ?></td>
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
                                    <th>Brand</th>
                                    <th>Activity</th>
                                    <th>Budget Activity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($operating_activity->result() as $budget) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= getBrandName($budget->BrandCode) ?></td>
                                        <td><?= getActivityName($budget->ActivityCode) ?></td>
                                        <td><?= number_format($budget->BudgetActivity)?></td>
                                        <td>
                                            <a href="<?=base_url($_SESSION['page'].'/lihatOperatingActivityDetail/'.$budget->BudgetCodeActivity)?>" class="btn btn-info btn-xs">Detail</a>
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