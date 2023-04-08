<div class="modal fade" id="modal_item" role="dialog">
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
                            </tr>
                        </thead>
                        <tbody class="tbody_item">
                            <?php if ($item->num_rows() > 0) { ?>
                                <?php foreach ($item->result() as $data) { ?>
                                    <tr>
                                        <td class="ItemCode">
                                            <?= $data->ItemCode ?>
                                        </td>
                                        <td class="BrandName"><?= $data->BrandName ?></td>
                                        <td class="Barcode"><?= $data->Barcode ?></td>
                                        <td class="ItemName"><?= $data->ItemName ?></td>
                                        <td class="Price"><?= $data->Price ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                Tidak Ada Data
                            <?php } ?>
                        </tbody>
                    </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="button_add" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#modal_item').modal('show');

        var table_item = $('#table_item').DataTable({
            'columnDefs': [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            'select': {
                'style': 'multi'
            },
            'order': [
                [1, 'asc']
            ]
        });

        $('#button_add').on('click', function() {
            var item_code = []
            var selected = table_item.column(0).checkboxes.selected().join();
            item_code = selected.split(',');
            // console.log(selected);
            // console.log(item_code);
            // console.log(item_code.length);
            var tbody = document.getElementById('tbodyItem');

            $.ajax({
                url: '<?= base_url($_SESSION['page']) . '/getItem' ?>',
                type: 'POST',
                data: {
                    item_code
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.item.length > 0) {

                        for (var i = 0; i < response.item.length; i++) {
                            var tr = document.createElement('tr');
                            var inputItemCode = document.createElement('input');
                            inputItemCode.type = 'hidden';
                            var tdBarcode = document.createElement('td');
                            var tdItemName = document.createElement('td');
                            var tdPrice = document.createElement('td');
                            var tdAvgSales = document.createElement('td');
                            tdAvgSales.setAttribute('style', 'display:none;');
                            var tdQty = document.createElement('td');
                            var tdTarget = document.createElement('td');
                            var tdPromo = document.createElement('td');
                            tdPromo.setAttribute('style', 'display:none;');
                            var tdCost = document.createElement('td');
                            var tdCosting = document.createElement('td');
                            var tdAction = document.createElement('td');

                            inputItemCode.className = 'itemCode_item';
                            tdBarcode.className = 'barcode_item';
                            tdItemName.className = 'itemName_item';
                            tdPrice.className = 'td_price_item';
                            tdQty.className = 'td_qty_item';
                            tdTarget.className = 'td_target_item';
                            tdPromo.className = 'td_promo_item';
                            tdCosting.className = 'td_costing_item';

                            inputItemCode.value = response.item[i].ItemCode;
                            tdBarcode.innerText = response.item[i].FrgnName;
                            tdItemName.innerText = response.item[i].ItemName;
                            tdBarcode.appendChild(inputItemCode);

                            var inputPrice = document.createElement('input');
                            inputPrice.setAttribute('onkeyup', 'calculate(this)');
                            inputPrice.value = response.item[i].Price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            inputPrice.classList.add('form-control', 'input_price');
                            tdPrice.appendChild(inputPrice);

                            var inputAvg = document.createElement('input');
                            inputAvg.setAttribute('onkeypress', 'javascript:return isNumber(event)');
                            inputAvg.setAttribute('onkeyup', 'formatNumber(this)');
                            inputAvg.setAttribute('readonly', 'readonly');
                            inputAvg.classList.add('form-control', 'input_avg_sales');
                            inputAvg.value = 0;
                            tdAvgSales.appendChild(inputAvg);

                            var inputQty = document.createElement('input');
                            inputQty.setAttribute('onkeypress', 'javascript:return isNumber(event)');
                            inputQty.setAttribute('onkeyup', 'calculate(this);formatNumber(this)');
                            inputQty.value = 0;
                            inputQty.classList.add('form-control', 'input_qty');
                            tdQty.appendChild(inputQty);

                            var inputTarget = document.createElement('input');
                            inputTarget.setAttribute('readonly', 'readonly');
                            inputTarget.value = 0;
                            inputTarget.classList.add('form-control', 'input_target');
                            tdTarget.appendChild(inputTarget);

                            var inputPromo = document.createElement('input');
                            inputPromo.setAttribute('onkeyup', 'calculate(this)');
                            inputPromo.setAttribute('readonly', 'readonly');

                            inputPromo.value = 0;
                            inputPromo.classList.add('form-control', 'input_promo');
                            tdPromo.appendChild(inputPromo);

                            var inputCost = document.createElement('input');
                            inputCost.setAttribute('onkeypress', 'javascript:return isNumber(event)');
                            inputCost.setAttribute('onkeyup', 'calculateTotalCosting();formatNumber(this);calculateCost(this);');
                            inputCost.value = 0;
                            inputCost.classList.add('form-control', 'input_cost');
                            tdCost.appendChild(inputCost);


                            var inputCosting = document.createElement('input');
                            inputCosting.setAttribute('onkeypress', 'javascript:return isNumber(event)');
                            inputCosting.setAttribute('onkeyup', 'calculateTotalCosting();formatNumber(this)');
                            inputCosting.setAttribute('readonly', 'readonly');
                            inputCosting.value = 0;
                            inputCosting.classList.add('form-control', 'input_costing');
                            tdCosting.appendChild(inputCosting);

                            tdAction.innerHTML = '<button onclick="deleteRow(this)" class="btn btn-danger btn-xs">Delete</button>';
                            tr.appendChild(tdBarcode);
                            tr.appendChild(tdItemName);
                            tr.appendChild(tdPrice);
                            tr.appendChild(tdAvgSales);
                            tr.appendChild(tdQty);
                            tr.appendChild(tdTarget);
                            tr.appendChild(tdPromo);
                            tr.appendChild(tdCost);
                            tr.appendChild(tdCosting);
                            tr.appendChild(tdAction);
                            tbody.appendChild(tr);
                        }
                        $('#modal_item').modal('hide');

                    } else {
                        //alert('Tidak Ada Data')
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: 'Data is not found',
                            // footer: '<a href="">Why do I have this issue?</a>'
                        })
                    }
                }
            })
        });
    })
</script>