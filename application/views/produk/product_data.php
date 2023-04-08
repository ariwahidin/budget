<section class="content-header">
    <h1>
    Items
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Items</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="pull-right">
                <a href="<?=site_url('product/refreshItem')?>" class="btn btn-primary btn-flat">
                    <i class="fa fa-refresh"></i> Update Item
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table_item">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Brand</th>
                        <th>Barcode</th>
                        <th>Nama product</th>
                        <th>Item Price</th>
                        <!-- <th class="text-center">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach($row as $key => $data){ ?>
                    <tr>
                        <td style="width:5%;"><?=$no++ ?>.</td>
                        <td><?= $data->BrandName?></td>
                        <td><?= $data->Barcode ?></td>
                        <td><?= $data->ItemName ?></td>
                        <td><?= number_format($data->item_price)?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>        
    </div>
</section>