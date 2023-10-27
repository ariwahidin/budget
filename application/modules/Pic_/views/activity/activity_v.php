<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Data Activity</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped table_brand">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Activity Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($activity->result() as $key => $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $value->ActivityName ?></td>
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
    $('.table_brand').DataTable({resposive : true});
</script>