<button type="button" class="btn btn-success" id="choose_item">Pilih Item</button>
<h4>Sales target</h4>
<div class="box box-widget">
    <div class="box-body table-responsive">
        <table id="table_tgt" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-left" rowspan="2" colspan="1"  width="3%">No</th>
                    <th class="text-left" rowspan="2" colspan="1"  width="20%">Product / Barcode</th>
                    <th class="text-center" rowspan="2" colspan="1" width="10%">Price</th>
                    <th class="text-center" rowspan="1" colspan="1" width="10%">AVG Sales</th>
                    <th class="text-center" rowspan="1" colspan="1" width="10%">Qty Target</th>
                    <th class="text-center" rowspan="2" colspan="1" width="10%">Total Target</th>
                    <th class="text-center" rowspan="2" colspan="1" width="5%%">Promo (%)</th>
                    <th class="text-center" rowspan="2" colspan="1" width="10%">Promo Value</th>
                    <th class="text-center" rowspan="2" colspan="1" width="10%">Total Costing</th>
                    <th class="text-center" rowspan="2" colspan="1" width="5%">Action</th>
                </tr>
                <tr>
                    <th rowspan="1" colspan="1">
                        <select id="AVGsls" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" <?=$from_sales == 'true' ? 'disabled' : '' ?>>
                            <option value="">-Pilih-</option>
                            <option value="last 3 month" <?=$sales_avg == '3' ? 'selected' : ''?>>Last 3 Month</option>
                            <option value="last year">Last Year</option>
                        </select>
                    </th>
                    <th rowspan="1" colspan="1">
                        <select id="multiple" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option value="">-Pilih-</option>
                            <option value="1.5">1.5x</option>
                            <option value="2">2x</option>
                        </select>
                    </th>
                </tr>
            </thead>
            <tbody id="target_table">
                <?php $this->view('transaction/proposal/ajax/target_item_data') ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <strong>Total</strong>
                    </td>
                    <td id="">
                        <input class="form-control" id="sum_total_target" value="<?=$sum_target?>" readonly>
                    </td>
                    <td></td>
                    <td></td>
                    <td colspan="">
                        <input class="form-control" id="sum_total_costing" value="<?=$sum_costing?>" readonly>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="modal fade" id="modal-edit-cart" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit Item Target</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="bgst">
                    <thead>
                        <tr>
                            <th style="width:50%">Item Name / Barcode</th>
                            <th>Price</th>
                            <th>Sales</th>
                            <th>Promo (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p id="item_name"></p>
                                <small id="item_barcode"></small>
                            </td>
                            <td>
                                <input id="cart_id" type="hidden" value="">
                                <input type="number" id="item_price" class="form-control" value="">
                            </td>
                            <td>
                                <input type="number" id="item_sales" class="form-control" value="">
                            </td>
                            <td>
                                <input type="number" id="item_promo" class="form-control" min="0" max="100" value="">
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-center">
                                <button id="simpan_edit_cart" class="btn btn-primary">Simpan</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="muncul_modal">

</div>
<script type="text/javascript">
    $('#multiple').select2()
</script>
<script type="text/javascript">
    $('#AVGsls').select2()
</script>
<script type="text/javascript">

    $(document).on('click','#edit_cart', function(){

        $('#cart_id').val($(this).data('cart_id'))
        $('#item_barcode').text($(this).data('item_barcode'))
        $('#item_name').text($(this).data('item_name'))
        $('#item_price').val($(this).data('item_price'))
        $('#item_sales').val($(this).data('item_sales'))
        $('#item_promo').val($(this).data('item_discount'))
        
    })

    //Edit Cart
    $(document).on('click','#simpan_edit_cart', function(){
        
        $.ajax({
            type: 'POST',
            url: '<?=site_url('proposal/edit_cart')?>',
            data:{
                'cart_id' : $('#cart_id').val(),
                'item_price' : $('#item_price').val(),
                'item_sales' : $('#item_sales').val(),
                'multiple_target' :$('#multiple').val(),
                'item_promo' : $('#item_promo').val(),
            },
            dataType:'JSON',
            success: function(result){
                if(result.success == true){
                    // alert('success')
                    $('#modal-edit-cart').modal('toggle');
                    $('#target_table').load('<?=site_url('proposal/getCartItem')?>');
                    $('#sum_total_target').val(result.sum_target);
                    $('#sum_total_costing').val(result.sum_costing);
                    $('#costing_actual').val(result.sum_costing);
                    $('#total_costing').val(result.sum_costing);
                    calculateTotalTarget()
                }
            }
        })
        
    })

    $(document).on('change', '#multiple', function (){
        // alert ('Qty Target '+$('#multiple').val()+'x Dari Sales AVG')
        $.ajax({
            type : 'POST',
            url: '<?=site_url('proposal/UpdateCartWhenMultipleTargetChanged')?>',
            data: {
                'multiple_target': $('#multiple').val(),
            },
            dataType:'JSON',
            success: function(result){
                if(result.success == true){
                    // alert('success')
                    $('#target_table').load('<?=site_url('proposal/getCartItem')?>')
                    $('#sum_total_target').val(result.sum_target)
                    $('#sum_total_costing').val(result.sum_costing)
                    $('#costing_actual').val(result.sum_costing);
                    $('#total_costing').val(result.sum_costing);
                }
            }
        })
    })

    // Fungsi untuk pilih produk
    $(document).on('click','#choose_item', function(){
        var code_brand = $('#brand_code').val()
        var from_sales = '<?=$from_sales?>';
        var sales_avg = '<?=$sales_avg?>';
        var bulan = $('#periode').val();
        bulan = bulan.substring(3,5);
        if(code_brand == ''){
            alert('Brand belum dipilih')
        }else{
            if(from_sales == 'true'){
                $('#muncul_modal').load('<?=site_url('proposal/getItemFromSalesTemp')?>',{sales_avg:sales_avg,bulan:bulan});
            }else{
                $('#muncul_modal').load('<?=site_url('proposal/getItemByBrand/')?>'+code_brand)
            }
        }
    })

    $("#table_tgt").on('change','input', function(){
        // calculateTotalTarget()
    })


    function calculateTotalTarget(){
        var totalTarget = 0;
        $('#table_tgt tr').each(function () {
            var valueQty = parseInt($('td', this).eq(4).find('input').val());
            if (!isNaN(valueQty)) {
                totalTarget += valueQty;
            }
        });
        // $('#sum_total_target').val(totalTarget);
    }

    function calculateTotalCosting(){
        var totalTarget = 0;
        $('#table_tgt tr').each(function () {
            var valueQty = parseInt($('td', this).eq(7).find('input').val());
            if (!isNaN(valueQty)) {
                totalTarget += valueQty;
            }
        });
        $('#sum_costing').val(totalTarget);

    }



    $(document).on('click','#del_cart',function(){
        var cart_id = $(this).data('cart_id')
        $.ajax({
            type: 'POST',
            url: '<?=site_url('proposal/delCartItem')?>',
            data: {
                'del_cart' : true,
                'cart_id' : cart_id,
            },
            dataType: 'json',
            success:function(response){
                if(response.success == true){
                    $('#target_table').load('<?=site_url('proposal/getCartItem')?>')
                    $('#sum_total_target').val(response.sum_target)
                    $('#sum_total_costing').val(response.sum_costing)
                    $('#costing_actual').val(response.sum_costing);
                    $('#total_costing').val(result.sum_costing);
                }else{
                    // alert('Tidak ada data')
                    $('#target_table').load('<?=site_url('proposal/getCartItem')?>')
                    $('#sum_total_target').val(response.sum_target)
                    $('#sum_total_costing').val(response.sum_costing)
                    $('#costing_actual').val(response.sum_costing);
                    $('#total_costing').val(result.sum_costing);
                }
            }
        })
        
        $('#sum').val('')
    })
</script>