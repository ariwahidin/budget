<div class="modal fade" id="modal-pilih-product" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Item</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="bgst">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Brand Name</th>
                            <th>Barcode</th>
                            <th>Item Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form>
                            <?php if($product->num_rows() != 0) {?>
                            <?php $no = 1; ?>
                            <?php foreach($product->result() as $i => $data) { ?>
                                <tr>
                                    <td style="width:2%"><?=$no++?></td>
                                    <td><?=$data->brand_name?></td>
                                    <td><?=$data->barcode?></td>
                                    <td><?=$data->product_name?></td>
                                    <td class="text-center">
                                        <input type="checkbox" name="product" value="<?=$data->id_product?>" >                                    
                                    </td>
                                </tr>
                            <?php } ?>
                                <tr style="text-align:right;">
                                    <td colspan="5">
                                        <button type="button" value="submit" class="btn btn-md btn-info" id="check">
                                            <i class="fa fa-check"></i> Ok
                                        </button>
                                    </td>
                                </tr>
                            <?php }else {
                                echo "<tr>
                                    <td class='text-center' colspan='5'>Tidak ada item</td>  
                                </tr>";
                            } ?>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

