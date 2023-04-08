<section class="content-header">
    <h1>
    Add Product
    <small>Tambah Product</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Add Product</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box_title"><?=ucfirst($page)?> Product</h3>
            <div class="pull-right">
                <a href="<?=site_url('product')?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="form-group">
                        <label for="product_name">Brand </label>
                        <div class="form-group input-group">
                            <input type="hidden" id="code_brand" value="<?=$row->BrandCode?>" >
                            <input type="text" id="brand_name" value="<?=$row->BrandName?>" class="form-control" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-pilih-brand">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Barcode *</label>
                        <input type="number" id="product_barcode" value="<?=$row->Barcode?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="product_name">Product Name *</label>
                        <input id="product_id" type="hidden" value="<?=$row->item_id?>">
                        <input type="text" id="product_name" value="<?=$row->ItemName?>" class="form-control" style="text-transform:uppercase" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="<?=$page?>" class="btn btn-success btn-flat">
                            <i class="fa fa-paper-plane"></i> Save
                        </button>
                        <button type="Reset" class="btn btn-flat">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Modal Tambah Product Pilih Brand-->
<div class="modal fade" id="modal-pilih-brand">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Brand</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="table_pilih_brand">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Brand Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach($brand->result() as $i => $data) { ?>
                            <tr>
                                <td style="width:2%"><?=$no++?></td>
                                <td><?=$data->BrandName?></td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-info" id="select"
                                    data-code_brand="<?=$data->BrandCode?>"
                                    data-brand_name="<?=$data->BrandName?>"
                                        <i class="fa fa-check"></i> Select
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click','#select',function(){
        $('#code_brand').val($(this).data('code_brand'))
        $('#brand_name').val($(this).data('brand_name'))               
        $('#modal-pilih-brand').modal('hide')
    })

    $(document).on('click','#add',function(){
        code_brand = $('#code_brand').val()
        product_name = $('#product_name').val()
        product_barcode = $('#product_barcode').val()
        product_price = $('#product_price').val()
        
        if(code_brand == ''){
            alert('Brand tidak terdaftar')
            $('#brand_name').focus()
        }else{
            // alert('Masuk proses')
            $.ajax({
                type : 'POST',
                url : '<?=site_url('product/process')?>',
                data : {'add_product' : true, 
                        'code_brand' : code_brand,
                        'product_name' : product_name, 
                        'product_bracode' : product_barcode,
                        'product_price' : product_price
                    },
                dataType:'json',
                success: function(result){
                    if(result.success == true){
                        alert('Product berhasil ditambahkan')                     
                        window.location="<?=site_url('product')?>";
                    } else {
                        alert('Gagal tambah')
                    }
                }
            })
        }
    })


    $(document).on('click','#edit',function(){
        code_brand = $('#code_brand').val()
        product_name = $('#product_name').val()
        item_id = $('#product_id').val()
        product_barcode = $('#product_barcode').val()
        product_price = $('#product_price').val()

        if(code_brand == ''){
            alert('Brand tidak terdaftar')
            $('#brand_name').focus()
        }else{
            // alert('Masuk proses')
            $.ajax({
                type : 'POST',
                url : '<?=site_url('product/process')?>',
                data : {'edit_product' : true, 
                        'code_brand' : code_brand,
                        'item_id' : item_id,
                        'product_name' : product_name,
                        'product_bracode' : product_barcode,
                        'product_price' : product_price
                    },
                dataType:'json',
                success: function(result){
                    if(result.success == true){
                        alert('Product berhasil diedit')                     
                        window.location="<?=site_url('product')?>";
                    } else {
                        alert('Gagal edit')
                    }
                }
            })
        }
    })
</script>