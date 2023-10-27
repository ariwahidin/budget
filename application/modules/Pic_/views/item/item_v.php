<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Data Item</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped table_item">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Brand Name</th>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Barcode</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($item->result() as $key => $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $value->BrandName ?></td>
                                        <td><?= $value->ItemCode ?></td>
                                        <td><?= $value->ItemName ?></td>
                                        <td><?= $value->Barcode ?></td>
                                        <td><?= $value->Price ?></td>
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
