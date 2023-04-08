<section class="content-header">
    <h1>
    Form Pengajuan Promotion Proposal
    <!-- <small>Penjualan</small> -->
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li>Transaction</li>
    <li class="active">Promotion Proposal</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-4">
            <div class="box box-widget">
                <div class="box-body">
                    <table width="100%">
                        <tr>
                            <td  style="vertical-align:center; width:20%">
                                <label for="">No. </label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <h4><b><span id="invoice"><?=$invoice?></span></b></h4>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:center">
                                <label for="user">User</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group" style="width:100%">
                                        <input class="form-control" type="text" id="user" value="<?=$this->fungsi->user_login()->nama?>" readonly>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php $this->view('transaction/sale/tr_pilih_brand') ?>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <div class="box box-widget">
                <div class="box-body">
                    <table width="100%">
                    
                        <!-- Menu Pilih Periode -->
                        <?php $this->view('transaction/sale/tr_periode') ?>

                        <tr>
                            <td style="vertical-align:top;">
                                <label for="">Outlet</label>
                            </td>
                            <td>
                                <div class="form-group input-group">
                                    <input id="customer_id" type="hidden">
                                    <input type="text" id="cust" class="form-control" readonly>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-customer">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                       
                        <!-- Menu Pilih promo -->
                        <?php $this->view('transaction/sale/menu_pilih_promo') ?>
                        
                    </table>
                </div>
            </div>
        </div>
    <!-- Tabel pilih outlet -->
    <?php $this->view('transaction/sale/tabel_outlet') ?>
    </div>

    <!-- Tabel pilih product -->
    <?php $this->view('transaction/sale/tabel_pilih_product') ?>
    
    <!-- Tabel Sales Target-->
    <?php $this->view('transaction/sale/tabel_sales_target') ?>

    <!-- Costing -->
    <div class="row">
        <div class="col-lg-12">
            <h4>Costing</h4>
            <div class="box box-widget">
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2" colspan="1">No.</th>
                                <th rowspan="2" colspan="1">Product Description</th>
                                <th class="text-center" rowspan="2" colspan="1">Price</th>
                                <th class="text-center" rowspan="2" colspan="1">Qty</th>
                                <th class="text-center" rowspan="2" colspan="1">Value</th>
                                <th class="text-center" rowspan="1" colspan="2"  >Promotion Cost</th>
                                <th class="text-center" rowspan="2" colspan="1">Action</th>
                            </tr>
                            <tr>
                                <th class="text-center" width="10%">Promo (%)</th>                                
                                <th class="text-center" width="10%">Total</th>
                            </tr>
                        </thead>
                        <tbody id="costing_table">
                            <?php $this->view('transaction/sale/costing_data') ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!--Proses Transaksi  -->
    <?php $this->view('transaction/sale/proses_simpan_form') ?>

</section>

<!-- Modal Edit Cart Item -->
<div class="modal fade" id="modal-item-edit">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Item</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="cartid_item">
                <div class="form-group">
                    <label for="product_item">Product Item</label>
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" id="barcode_item" class="form-control" readonly>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="product_item" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="price_item">Price</label>
                    <input type="number" id="price_item" min="0" class="form-control">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="qty_item">Last Year</label>
                            <input type="number" id="input_qty_last_year" min="0" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="qty_item">Last 3 Month</label>
                            <input type="number" id="input_qty_last_3_month" min="0" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="qty_item">Total Sales Estimation</label>
                            <!-- <input type="number" id="input_qty_total_sales_estimation" min="0" class="form-control"> -->
                            <select class="form-control" id="input_qty_total_sales_estimation" data-placeholder=""  style="width: 100%;">
                                <option value="">- Pilih -</option>
                                <option value="0.5">0.5 x</option>
                                <option value="1.5">1.5 x</option>
                                <option value="2">2 x</option>
                             </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" id="edit_cart" class="btn btn-flat btn-success">
                        <i class="fa fa-plane"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pilih outlet -->
<?php $this->view('transaction/sale/modal_pilih_outlet') ?>
<!-- Modal pilih product -->
<?php $this->view('transaction/sale/modal_pilih_product') ?>


<!-- Modal Edit Promo -->
<div class="modal fade" id="modal-costing-edit">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Promo</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="cartid_item_promo">
                <input type="hidden" id="sales_target_promo">
                <div class="form-group">
                    <label for="product_item">Product Description</label>
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" id="barcode_product_costing" class="form-control" readonly>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="item_product_costing" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="price_item">Price</label>
                    <input type="number" id="price_costing" min="0" class="form-control">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="qty_item">Discount (%)</label>
                            <input type="number" id="discount_costing" min="0" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" id="edit_promo_costing" class="btn btn-flat btn-success">
                        <i class="fa fa-plane"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pilih Brand-->
<?php $this->view('transaction/sale/modal_pilih_brand') ?>

<!-- Modal Pilih Brand-->
<?php $this->view('transaction/sale/modal_pilih_product') ?>

<script type="text/javascript">

    function calculateColumnQtyTargetLastYear() {
        var totalQty = 0;
        $('#target_table tr').each(function () {
            var valueQty = parseInt($('td', this).eq(4).text());
            if (!isNaN(valueQty)) {
                totalQty += valueQty;
            }
        });
        $('#total_target_last_year b').text(totalQty);
    }

    function calculateColumnQtyTarget() {
        var totalQty = 0;
        $('#target_table tr').each(function () {
            var valueQty = parseInt($('td', this).eq(5).text());
            if (!isNaN(valueQty)) {
                totalQty += valueQty;
            }
        });
        $('#total_target_qty b').text(totalQty);
    }

    function calculateColumnQtyEstimation() {
        var totalQty = 0;
        $('#target_table tr').each(function () {
            var valueQty = parseInt($('td', this).eq(6).text());
            if (!isNaN(valueQty)) {
                totalQty += valueQty;
            }
        });
        $('#total_target_qty_estimation b').text(totalQty);
    }

    function calculateColumnTotalTargetEstimation() {
        var totalQty = 0;
        $('#target_table tr').each(function () {
            var valueQty = parseInt($('td', this).eq(6).text());
            if (!isNaN(valueQty)) {
                totalQty += valueQty;
            }
        });
        $('#total_target_estimation b').text(totalQty);
    }
    
    function calculateColumnQtyCosting() {
        var totalQtyCosting = 0;
        $('#costing_table tr').each(function () {
            var valueQtyCosting = parseInt($('td', this).eq(3).text());
            if (!isNaN(valueQtyCosting)) {
                totalQtyCosting += valueQtyCosting;
            }
        });
        $('#qty_costing b').text(totalQtyCosting);
    }

    function calculateColumnTotalCosting() {
        var totalCosting = 0;
        $('#costing_table tr').each(function () {
            var valueCosting = parseInt($('td', this).eq(6).text());
            if (!isNaN(valueCosting)) {
                totalCosting += valueCosting;
            }
        });
        $('#total_costing b').text(totalCosting);
    }

    $(document).on('click','#edit_promo',function(){
        $('#cartid_item_promo').val($(this).data('cartid'))
        $('#barcode_product_costing').val($(this).data('barcode'))
        $('#item_product_costing').val($(this).data('product'))
        $('#price_costing').val($(this).data('price'))
        $('#discount_costing').val($(this).data('discount'))
        $('#sales_target_promo').val($(this).data('sales_target'))
    })


    $(document).on('click','#edit_promo_costing',function(){
        var cart_id = $('#cartid_item_promo').val()
        var discount = $('#discount_costing').val()
        var price = $('#price_costing').val()
        var target_sales = $('#sales_target_promo').val()

            $.ajax({
                type : 'POST',
                url : '<?=site_url('sale/process')?>',
                data : {'edit_promo_costing' : true, 
                        'cart_id' : cart_id,
                        'discount' : discount,
                        'price' : price,
                        'sales_target' : target_sales
                    },
                dataType:'json',
                success: function(result){
                    if(result.success == true){
                        $('#costing_table').load('<?=site_url('sale/costing_data')?>',function(){
                            calculateColumnQtyCosting()
                            calculateColumnTotalCosting()
                        })
                        alert('Data promo berhasil disimpan')
                        $('#modal-costing-edit').modal('hide')
                    }
                }
            })
    })

    $(document).ready(function(){
        calculateColumnQtyTargetLastYear()
        calculateColumnQtyTarget()
        calculateColumnQtyEstimation()
        calculateColumnTotalTargetEstimation()
        calculateColumnQtyCosting()
        calculateColumnTotalCosting()
    })


</script>