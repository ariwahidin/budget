<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h4>Budget Activity Detail</h4>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <table>
                            <tr>
                                <td>Brand</td>
                                <td>&nbsp;:&nbsp; <?= $operating_activity_detail->row()->BrandName ?> </td>
                            </tr>
                            <tr>
                                <td>Periode</td>
                                <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($operating_activity_detail->row(0)->Month)) . ' s/d ' . date('M-Y', strtotime($operating_activity_detail->row(11)->Month)) ?></td>
                            </tr>
                            <tr>
                                <td>Activity</td>
                                <td>&nbsp;:&nbsp; <?= $operating_activity_detail->row()->ActivityName ?></td>
                            </tr>
                            <tr>
                                <?php
                                $total_operating = 0;
                                foreach ($operating_activity_detail->result() as $data) {
                                    $total_operating += (float)$data->BudgetActivity;
                                }
                                ?>
                                <td>Operating</td>
                                <td>&nbsp;:&nbsp; <?= number_format($total_operating) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table-striped table_operating">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Brand</th>
                                    <th>Activity</th>
                                    <th>Month</th>
                                    <th>Activity Operating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($operating_activity_detail->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= getBrandName($data->BrandCode) ?></td>
                                        <td><?= getActivityName($data->ActivityCode) ?></td>
                                        <td><?= date('M-Y', strtotime($data->Month)) ?></td>
                                        <td><?= number_format($data->BudgetActivity) ?></td>
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
    // $('.table_operating').dataTable();
</script>