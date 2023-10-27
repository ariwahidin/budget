<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Data Group</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped table_group">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Group Code</th>
                                    <th>Group Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($group->result() as $key => $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $value->GroupCode ?></td>
                                        <td><?= $value->GroupName ?></td>
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
    $('.table_group').DataTable({resposive : true});
</script>