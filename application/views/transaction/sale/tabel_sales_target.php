<div class="row">
    <div class="col-lg-12">
        <button type="button" class="btn btn-success" id="chose_item">Pilih Item</button>
        <h4>Sales target</h4>
        <div class="box box-widget">
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%" rowspan="2" colspan="1">No.</th>
                            <th class="text-left" rowspan="2" colspan="1">Barcode</th>
                            <th class="text-left" rowspan="2" colspan="1">Product Description</th>
                            <th class="text-center" rowspan="2" colspan="1">Price</th>
                            <th class="text-center" rowspan="1" colspan="2" style="width:15%">AVG Sales</th>
                            <th class="text-center" rowspan="2" colspan="1" width="10%">Total Sales Estimation</th>
                            <th class="text-center" rowspan="2" colspan="1" width="15%">Value</th>
                            <th class="text-center" rowspan="2" colspan="1" >Action</th>
                        </tr>
                        <tr>
                            <th class="text-center">Last Year</th>
                            <th class="text-center">Last 3 Month</th>
                        </tr>
                    </thead>
                    <tbody id="target_table">
                        
                        <?php $this->view('transaction/sale/target_data') ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Fungsi untuk pilih produk
    $(document).on('click','#chose_item',function(){
        $id_brand = $('#brand_id').val()
        $.ajax({
            success: function(){
                if($id_brand != ''){
                    $('#bgst').load('<?=site_url('sale/getProduct/')?>'+$id_brand, function(){
                    $('#modal-pilih-product').modal('show')
                        
                    $("#check").on('click', function () {

                            var product = document.getElementsByName("product")
                            var isiProduct = [];
                            for(var i = 0; i < product.length; i++ ){
                                if(product[i].checked){
                                    isiProduct.push(product[i].value)
                                }
                            }
                            
                            // console.log(isiProduct)

                            $.ajax({
                                type : 'POST',
                                url : '<?=site_url('sale/process')?>',
                                data : {
                                    'add_cart' : true,
                                    'isi_product' : isiProduct
                                },
                                dataType:'json',
                                success: function(result){

                                    if(result.data_sama == true){
                                        alert('Item '+result.product+' sudah dipilih, silahkan pilih item lain')
                                    }

                                    if(result.success == true){                                        
                                        alert('Berhasil')
                                        $('#modal-pilih-product').modal('hide')
                                        $('#target_table').load('<?=site_url('sale/target_data')?>',function(){
                                            
                                            calculateColumnQtyTargetLastYear()
                                            calculateColumnQtyTarget()
                                            calculateColumnQtyEstimation()
                                            calculateColumnTotalTargetEstimation()
                                        })
                                        $('#costing_table').load('<?=site_url('sale/costing_data')?>',function(){
                                            calculateColumnQtyCosting()
                                            calculateColumnTotalCosting()
                                        })

                                    }else{                                        
                                        alert('Gagal')                                        
                                    }
                                }
                            })
                    
                        })
                    })
                }else{
                    alert('Data tidak ditemukan')
                }
            } 
        })
    })


    $(document).on('click','#del_cart',function(){
        // if(confirm('Apakah Anda yakin?')){
            var cart_id = $(this).data('cartid')
            $.ajax({
                type: 'POST',
                url:'<?=site_url('sale/cart_del')?>',
                dataType:'json',
                data:{'cart_id':cart_id},
                success: function(result){
                    if(result.success == true){
                        $('#target_table').load('<?=site_url('sale/target_data')?>',function(){
                            
                            calculateColumnQtyTargetLastYear()
                            calculateColumnQtyTarget()
                            calculateColumnQtyEstimation()
                            calculateColumnTotalTargetEstimation()
                        }) 
                        $('#costing_table').load('<?=site_url('sale/costing_data')?>',function(){
                            calculateColumnQtyCosting()
                            calculateColumnTotalCosting()
                        })

                        // alert('Data berhasil dihapus')
                    }else{
                        alert('Gagal hapus item cart')
                    }
                }
            })
        // }
    })


    $(document).on('click','#update_cart',function(){

        // alert('Tessst')
        $('#product_item').val($(this).data('product'))
        $('#stock_item').val($(this).data('stock'))
        $('#cartid_item').val($(this).data('cartid'))
        $('#barcode_item').val($(this).data('barcode'))
        $('#price_item').val($(this).data('price'))
        $('#input_qty_last_year').val($(this).data('qty_last_year'))
        $('#input_qty_last_3_month').val($(this).data('qty_last_3_month'))
        $('#input_qty_total_sales_estimation').val($(this).data('multiple_estimation'))
        $('#total_item').val($(this).data('total'))
    })


    // Fungsi untuk update cart produk
    $(document).on('click','#edit_cart',function(){
        // alert('Gaass')
        var cart_id = $('#cartid_item').val()
        var price = $('#price_item').val()
        var input_qty_last_year = $('#input_qty_last_year').val()
        var input_qty_last_3_month = $('#input_qty_last_3_month').val()
        var input_qty_sales_estimation = $('#input_qty_total_sales_estimation').val()
        if(price == '' || price < 1){
            alert('Harga tidak boleh kosong')
            $('#price_item').focus()
        }else if(input_qty_sales_estimation == '' || input_qty_sales_estimation < 0.5){
            alert('Sales estimation tidak boleh kosong')
            $('#input_qty_sales_estimation').focus('')
        }else if(input_qty_last_3_month == '' || input_qty_last_3_month <= 0){
            alert('Last 3 month tidak boleh kosong')
            $('input_qty_last_3_month').focus()
        }
        else {
            $.ajax({
                type : 'POST',
                url : '<?=site_url('sale/process')?>',
                data : {'edit_cart' : true, 
                        'cart_id' : cart_id, 
                        'price' : price,
                        'input_qty_last_year' : input_qty_last_year,
                        'input_qty_last_3_month' : input_qty_last_3_month,
                        'input_qty_sales_estimation' : input_qty_sales_estimation
                    },
                dataType:'json',
                success: function(result){

                    if(result.success == true){
                        $('#target_table').load('<?=site_url('sale/target_data')?>',function(){
                            calculateColumnQtyTargetLastYear()
                            calculateColumnQtyTarget()
                            calculateColumnQtyEstimation()
                            calculateColumnTotalTargetEstimation()
                        })
                        $('#costing_table').load('<?=site_url('sale/costing_data')?>',function(){
                            calculateColumnQtyCosting()
                            calculateColumnTotalCosting()
                        })
                        alert('Data berhasil ter-update')
                       
                        $('#modal-item-edit').modal('hide')
                    } else {
                        alert('Data item cart tidak ter-update')
                        $('#modal-item-edit').modal('hide')
                    }
                }
            })
        }
    })
</script>