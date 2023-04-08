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
                <form id="frm-example" name="frm-example">
                <table class="table table-bordered table-striped" id="table_item">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Brand Name</th>
                            <th>Barcode</th>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Sales</th>
                            <!-- <th class="text-center">Actions</th> -->
                        </tr>
                    </thead>
                    <tbody class="tbodySales">
                        <?php if($product->num_rows() > 0){?>
                            <?php foreach($product->result() as $data){?>
                                <tr class="trSales">
                                    <td><?=$data->ItemCode?></td>
                                    <td><?=getBrandNameItem($data->ItemCode)?></td>
                                    <td><?=getBarcodeItem($data->ItemCode)?></td>
                                    <td><?=getNameItem($data->ItemCode)?></td>
                                    <td class="price"><?=getPriceItem($data->ItemCode)?></td>
                                    <td class="sales"><?=ceil($data->Sales)?></td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                            Tidak Ada Data
                        <?php } ?>
                    </tbody>
                </table>
                     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="submit" type="submit" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#modal-pilih-product').modal('show')
    })


    var table = $('#table_item').DataTable({
        'columnDefs': [
            {
                'targets': 0,
                'checkboxes': {
                'selectRow': true
                }
            }
        ],
        'select': {
            'style': 'multi'
        },
        'order': [[1, 'asc']]
    });


    // Handle form submission event
    $('#submit').on('click', function(e){
        myArr = []
        var rows_selected = table.column(0).checkboxes.selected().join();
        myArr = rows_selected.split(',');


        var sales = [];
        var salesClass = $('.tbodySales tr.selected td.sales');
        for(var i = 0; i < salesClass.length; i++){
            sales.push(salesClass[i].innerText);
        }

        var price = [];
        var priceClass = $('.tbodySales tr.selected td.price');
        for(var a = 0; a < priceClass.length; a++){
            price.push(priceClass[a].innerText);
        }

        // console.log(myArr)
        $.ajax({
            type: 'POST',
            url: '<?=site_url('proposal/addCartItem')?>',
            data: {
                'item_id' : myArr,
                'price' : price,
                'sales' : sales,
            },
            dataType: 'json',
            success:function(response){
                if(response.success == true){
                    $('#modal-pilih-product').modal('hide');
                    $('#target_table').load('<?=site_url('proposal/getCartItem')?>')
                    $('#sum_total_target').val(response.sum_target)
                    $('#sum_total_costing').val(response.sum_costing)
                }else{
                    alert('Item sama');
                    $('#modal-pilih-product').modal('hide');
                }
            }
        })
    });



</script>



