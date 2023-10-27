<?php $this->view('header') ?>
<!-- <php var_dump(is_delete())?> -->
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Data Brand</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped table_brand">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Brand Code</th>
                                    <th>Brand Name</th>
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
    $('.table_brand').dataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url($_SESSION['page'] . '/getListBrand') ?>",
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [0],
            "orderable": false
        }],
    });
</script>