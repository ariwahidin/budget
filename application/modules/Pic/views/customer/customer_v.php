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
                        <table class="table table-bordered table-striped table_customer">
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
    $('.table_customer').dataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url($_SESSION['page'] . '/getListCustomer') ?>",
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [0],
            "orderable": false
        }],
    });
</script>
