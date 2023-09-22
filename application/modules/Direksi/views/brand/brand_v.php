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
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($brand->result() as $key => $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $value->BrandCode ?></td>
                                        <td><?= $value->BrandName ?></td>
                                        <!-- <td>
                                            <button class="btn btn-danger btn-xs">Delete</button>
                                        </td> -->
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