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
                <table class="table table-bordered table-striped" id="table_item">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Brand Name</th>
                            <th>Barcode</th>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Sales</th>
                        </tr>
                    </thead>
                    <tbody class="tbodySales">
                        <?php if($item->num_rows() > 0){?>
                            <?php foreach($item->result() as $data){?>
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
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#modal-pilih-product').modal('show');
    });

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
    $('#submit').on('click', function(){

        item_code = []
        var rows_selected = table.column(0).checkboxes.selected().join();
        item_code = rows_selected.split(',');
        const item = getItemData(item_code);
        // console.log(item);

        for(var i = 0; i < item_code.length; i++){  
            
            var tbody_target = document.getElementById("tbody_target");
            var tr = document.createElement("tr");
            var tdProduct = document.createElement("td");
            var tdBarcode = document.createElement("td");
            var tdPrice = document.createElement("td");
            // tdPrice.classList.add('tdPrice');
            var tdSales = document.createElement("td");
            var tdTarget = document.createElement("td");
            var tdTotalTarget = document.createElement("td");
            var tdPromo = document.createElement("td");
            var tdTotalCosting = document.createElement("td");
            var tdAction = document.createElement("td");

            var buttonDelete = document.createElement("button");
            var input = document.createElement("input");
            const inputPrice = document.createElement('input');
            inputPrice.classList.add('form-control', 'inputPrice');
            inputPrice.value = item[i].Price;
            const inputSales = document.createElement('input');
            inputSales.classList.add('form-control', 'inputSales');
            inputSales.setAttribute('type','number');
            inputSales.setAttribute('readonly', 'readonly');
            const inputTarget = document.createElement('input');
            inputTarget.classList.add('form-control', 'inputTarget');
            inputTarget.setAttribute('type','number');
            const inputTotalTarget = document.createElement('input');
            inputTotalTarget.classList.add('form-control', 'inputTotalTarget');
            inputTotalTarget.setAttribute('type','number');
            inputTotalTarget.setAttribute('readonly','readonly');
            const inputPromo = document.createElement('input');
            inputPromo.classList.add('form-control', 'inputPromo');
            inputPromo.setAttribute('type','number');
            const inputTotalCosting = document.createElement('input');
            inputTotalCosting.classList.add('form-control', 'inputTotalCosting');
            inputTotalCosting.setAttribute('type','number');
            inputTotalCosting.setAttribute('readonly','readonly');
            const inputHiddenItemCode = document.createElement('input');
            inputHiddenItemCode.setAttribute('type', 'hidden');
            inputHiddenItemCode.classList.add('itemCode');
            inputHiddenItemCode.value = item[i].ItemCode;

            buttonDelete.classList.add('btn','btn-xs','btn-danger', 'buttonDeleteRow');
            buttonDelete.textContent = "delete";

            tdProduct.textContent = item[i].ItemName;
            tdProduct.appendChild(inputHiddenItemCode);
            tdBarcode.textContent = item[i].FrgnName;
            tdPrice.appendChild(inputPrice);
            tdSales.appendChild(inputSales);
            tdTarget.appendChild(inputTarget);
            tdTotalTarget.appendChild(inputTotalTarget);
            tdPromo.appendChild(inputPromo);
            tdTotalCosting.appendChild(inputTotalCosting);
            tdAction.appendChild(buttonDelete);
            tr.appendChild(tdProduct);
            tr.appendChild(tdBarcode);
            tr.appendChild(tdPrice);
            // tr.appendChild(tdSales);
            tr.appendChild(tdTarget);
            tr.appendChild(tdTotalTarget);
            tr.appendChild(tdPromo);
            tr.appendChild(tdTotalCosting);
            tr.appendChild(tdAction);
            tbody_target.appendChild(tr);
        }
        $('#modal-pilih-product').modal('hide');

    });

    function getItemData(itemCode){
        var jqXHR = $.ajax({
            url : '<?=site_url('ProposalPromosi_C/getItemForTarget')?>',
            type : 'POST',
            async: false,
            data : {
                code : itemCode,
            },
        });
        return JSON.parse(jqXHR.responseText);
    }

</script>