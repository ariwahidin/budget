<?php $this->view('header') ?>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Data Customer</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped table_item">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Card Code</th>
                                    <th>Group Name</th>
                                    <th>Customer Name</th>
                                    <th>Group Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($customer->result() as $key => $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $value->CardCode ?></td>
                                        <td><?= $value->GroupName ?></td>
                                        <td><?= $value->CustomerName ?></td>
                                        <td><?= $value->GroupCode ?></td>
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
    $('.table_item').DataTable({resposive : true});
</script>
