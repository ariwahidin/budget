<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Data Operating</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table_operating">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Brand</th>
                                    <th>Activity</th>
                                    <th>Month</th>
                                    <th>Operating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($operating_activity_detail->result() as $data){ ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=getBrandName($data->BrandCode)?></td>
                                        <td><?=getActivityName($data->ActivityCode)?></td>
                                        <td><?=date('M-Y', strtotime($data->Month))?></td>
                                        <td><?=number_format($data->OperatingBudget)?></td>
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
    $('.table_operating').DataTable({resposive : true});
</script>