<section class="content-header">
    <h1>
    Sales Report
    <small>Laporan Penjualan</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="#">Reports</a></li>
    <li class="active">Sales</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box_title">Data Report</h3>
            <!-- <div class="pull-right">
                <a href="<?=site_url('brand/add')?>" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i> Create
                </a>
            </div> -->
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No. Document</th>
                        <th>Pic</th>
                        <th>Brand</th>
                        <th>Tanggal Transaksi</th>
                        <th>Periode</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                   <?php $no = 1; ?>
                   <?php foreach($hasil->result() as $h => $data){ ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$data->invoice?></td>
                        <td><?=$data->pic?></td>
                        <td><?=$data->brand_name?></td>
                        <td><?=indo_date($data->created)?></td>
                        <td><?=indo_date($data->periode_start).' s/d '.indo_date($data->periode_end)?></td>
                        <td class="text-center">
                            <a href="<?=site_url('report/lihat_report/').$data->sale_id?>">
                                <button id="" class="btn btn-xs btn-info" data-outlet_id="2">
                                    <i class="fa fa-eye"></i> Lihat
                                </button>
                            </a>
                            <button id="" class="btn btn-xs btn-primary" data-outlet_id="2">
                                <i class="fa fa-print"></i> Cetak
                            </button>
                            <button id="" class="btn btn-xs btn-danger" data-outlet_id="2">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- <div class="box-footer clearfix">
            <div class="pagination pagination-sm no-margin pull-right">
                <?=$pagination?>
            </div>
        </div> -->
    </div>

</section>

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Sales Report Detail</h4>
            </div>
            <div class="modal-body table-responsive">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Type Promotion
                    </div>
                    <div class="panel-body">
                        <ul>
                            <li>Promo 1</li>
                            <li>Promo 2</li>
                        </ul>
                    </div>
                </div>
                <table class="table table-bordered no-margin">
                    <tbody>
                        <tr>
                            <th style="width:20%">Invoice</th>
                            <td style="width:30%"><span id="invoice"></span></td>
                            <th style="width:20%">Customer</th>
                            <td style="width:30%"><span id="cust"></span></td>
                        </tr>
                        <tr>
                            <th>Date Time</th>
                            <td><span id="datetime"></span></td>
                            <th>Cashier</th>
                            <td><span id="cashier"></span></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td><span id="total"></alspan></td>
                            <th>Cash</th>
                            <td><span id="cash"></span></td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td><span id="discount"></span></td>
                            <th>Change</th>
                            <td><span id="change"></span></td>
                        </tr>
                        <tr>
                            <th>Grand Total</th>
                            <td><span id="grandtotal"></span></td>
                            <th>Note</th>
                            <td><span id="note"></span></td>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <td colspan="3"><span id="product"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click','#detail',function(){
        $('#invoice').text($(this).data('invoice'))
        $('#cust').text($(this).data('customer'))
        $('#datetime').text($(this).data('date')+' '+$(this).data('time'))
        $('#total').text($(this).data('total'))
        $('#discount').text($(this).data('discount'))
        $('#change').text($(this).data('remaining'))
        $('#grandtotal').text($(this).data('grandtotal'))
        $('#note').text($(this).data('note'))
        $('#cashier').text($(this).data('cashier'))
        $('#cash').text($(this).data('cash'))

        var product = '<table class="table no-margin">'
        product += '<tr><th>Item</th><th>Price</th><th>Qty</th><th>Disc</th><th>Total</th></tr>'
        $.getJSON('<?=site_url('report/sale_product/')?>'+$(this).data('saleid'),function(data){
            $.each(data, function(key, val){
                product += '<tr><td>'+val.name+'</td><td>'+val.price+'</td><td>'+val.qty+'</td><td>'+val.discount_item+'</td><td>'+val.total+'</td></tr>'
            })

            product += '</table>'
            $('#product').html(product)
        })
    })
</script>