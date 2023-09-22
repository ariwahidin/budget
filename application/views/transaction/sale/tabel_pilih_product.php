<!-- <div class="row">
    <div class="col-lg-12">
        <h4>Tabel Product</h4>
        <div class="box box-widget">
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped" id="table_product_t">
                    <thead>
                        <tr>
                            <th style="width:5%">No.</th>
                            <th>Brand</th>
                            <th>Barcode</th>
                            <th>Nama Product</th>
                            <th>Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_product">
                        
                    <?php $this->view('transaction/sale/product_data') ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).on('click','#select_brand',function(){
        $('#brand_id').val($(this).data('id_brand'))
        $('#brand_name').val($(this).data('brand_name'))
        $('#modal-pilih-brand').modal('hide')

        pilihProductByBrand()
        
    })

    function pilihProductByBrand(){

        var id_brand = $('#brand_id').val()
        $.ajax({
            type : 'POST',
            url : '<?=site_url('product/get_product_by_brand')?>',
            data : {'id_brand' : id_brand,
                },
            dataType:'json',
            success: function(result){

                if(result.success == true){
                    // alert('Ada Data dari '+id_brand)
                $('#table_product').load('<?=site_url('product/product_data/')?>'+id_brand,function(){
                    $('#table_product_t').DataTable({resposive : true})
                })
                    
                }else{
                    alert('Brand yang dipilih tidak memiliki product')
                }
            }
        })
        
    }

</script> -->