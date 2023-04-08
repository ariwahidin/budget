<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- <?php var_dump($budget->result()) ?> -->
                <div class="box">
                    <div class="box-header">
                        <h4>Data Budget</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table_budget">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Brand</th>
                                    <th>Month</th>
                                    <th>Principal Target</th>
                                    <th>Target Anp</th>
                                    <th>Operating Budget</th>
                                    <th>Actual Purchase</th>
                                    <th>Actual Anp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($budget->result() as $key => $b) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $b->BRAND ?></td>
                                        <td><?= date('M-Y', strtotime($b->month)) ?></td>
                                        <td><?= number_format($b->PrincipalTarget) ?></td>
                                        <td><?= number_format($b->PrincipalTargetAnp) ?></td>
                                        <td><?= number_format($b->OperatingBudget) ?></td>
                                        <td><?= number_format($b->Actual_Purchase) ?></td>
                                        <td><?= number_format($b->Actual_ANP) ?></td>
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
    $('.table_budget').dataTable();
</script>