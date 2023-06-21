<div class="modal fade" id="modal_item" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>PILIH PRODUCT</b></h4>
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
                                        <td class="Price"><?= round($data->Price) ?></td>
                                        <td class="Quantity"><?= round($data->Quantity) ?></td>
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
        loadingHide();
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
            var selected = table_item.column(0).checkboxes.selected().join();
            if (selected.length > 0) {
                loadingShow();
                var item_code = []
                item_code = selected.split(',');
                var tbody = document.getElementById('tbodyItem');
                var brand = '<?= $_POST['brand'] ?>';
                var customer = "<?= $_POST['customer_code'] ?>";
                var start_date = '<?= $_POST['start_date'] ?>';
                var avg_sales = '<?= $_POST['avg_sales'] ?>';

                // console.log(selected.length)
                // console.log(selected)
                // console.log(item_code)
                $.ajax({
                    url: '<?= base_url($_SESSION['page']) . '/getItemFromPenjualan' ?>',
                    type: 'POST',
                    data: {
                        item_code,
                        brand,
                        customer,
                        start_date,
                        avg_sales,
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        // return false;
                        if (response.item.length > 0) {

                            for (var i = 0; i < response.item.length; i++) {
                                var tr = document.createElement('tr');
                                var inputItemCode = document.createElement('input');
                                inputItemCode.type = 'hidden';
                                var tdBarcode = document.createElement('td');
                                var tdItemName = document.createElement('td');
                                var tdPrice = document.createElement('td');
                                var tdAvgSales = document.createElement('td');
                                var tdQty = document.createElement('td');
                                var tdTarget = document.createElement('td');
                                var tdPromo = document.createElement('td');
                                var tdPromoValue = document.createElement('td');
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
                                tdBarcode.innerText = response.item[i].Barcode;
                                tdItemName.innerText = response.item[i].ItemName;
                                tdBarcode.appendChild(inputItemCode);

                                var inputPrice = document.createElement('input');
                                inputPrice.setAttribute('onkeyup', 'calculate(this)');
                                inputPrice.setAttribute('data-price-item-code', response.item[i].ItemCode);
                                // inputPrice.setAttribute('readonly', 'readonly');
                                inputPrice.value = Math.round(response.item[i].Price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                // inputPrice.value = 0;
                                inputPrice.classList.add('form-control', 'input_price');
                                tdPrice.appendChild(inputPrice);

                                var inputAvg = document.createElement('input');
                                inputAvg.setAttribute('onkeypress', 'javascript:return isNumber(event)');
                                inputAvg.setAttribute('onkeyup', 'formatNumber(this)');
                                inputAvg.setAttribute('readonly', 'readonly');
                                inputAvg.classList.add('form-control', 'input_avg_sales');
                                inputAvg.value = Math.round(response.item[i].Quantity);
                                // inputAvg.value = 0;
                                tdAvgSales.appendChild(inputAvg);

                                var inputQty = document.createElement('input');
                                inputQty.setAttribute('onkeypress', 'javascript:return isNumber(event)');
                                inputQty.setAttribute('onkeyup', 'calculate(this);formatNumber(this)');
                                inputQty.setAttribute('data-item-code-estimation', response.item[i].ItemCode);
                                inputQty.setAttribute('readonly', 'readonly');
                                inputQty.value = 0;
                                inputQty.classList.add('form-control', 'input_qty');
                                tdQty.appendChild(inputQty);

                                var inputTarget = document.createElement('input');
                                inputTarget.setAttribute('readonly', 'readonly');
                                inputTarget.setAttribute('data-target-item-code', response.item[i].ItemCode)
                                inputTarget.value = 0;
                                inputTarget.classList.add('form-control', 'input_target');
                                tdTarget.appendChild(inputTarget);

                                var inputPromo = document.createElement('input');
                                inputPromo.setAttribute('onkeyup', 'calculate(this)');
                                inputPromo.setAttribute('readonly', 'readonly');
                                inputPromo.value = 0;
                                inputPromo.classList.add('form-control', 'input_promo');
                                tdPromo.appendChild(inputPromo);

                                var inputValuePromo = document.createElement('input');
                                inputValuePromo.value = 0;
                                inputValuePromo.setAttribute('onkeyup', 'calculateValuePromo(this);formatNumber(this)');
                                inputValuePromo.setAttribute('data-value-item-code', response.item[i].ItemCode);
                                inputValuePromo.setAttribute('onkeypress', 'javascript:return isNumber(event)');
                                inputValuePromo.classList.add('form-control', 'input_value_promo');
                                tdPromoValue.appendChild(inputValuePromo);

                                var inputCosting = document.createElement('input');
                                inputCosting.setAttribute('readonly', 'readonly');
                                inputCosting.setAttribute('data-costing-item-code', response.item[i].ItemCode);
                                inputCosting.value = 0;
                                inputCosting.setAttribute('onkeypress', 'javascript:return isNumber(event)');
                                inputCosting.setAttribute('onkeyup', 'calculateCosting(this);formatNumber(this)')
                                inputCosting.classList.add('form-control', 'input_costing');
                                tdCosting.appendChild(inputCosting);

                                tdAction.innerHTML = '<button onclick="deleteRow(this)" class="btn btn-danger btn-xs btn_delete_product">Delete</button>';
                                tr.appendChild(tdBarcode);
                                tr.appendChild(tdItemName);
                                tr.appendChild(tdPrice);
                                tr.appendChild(tdAvgSales);
                                tr.appendChild(tdQty);
                                tr.appendChild(tdTarget);
                                tr.appendChild(tdPromo);
                                tr.appendChild(tdPromoValue);
                                tr.appendChild(tdCosting);
                                tr.appendChild(tdAction);
                                tbody.appendChild(tr);
                            }
                            $('#modal_item').modal('hide');
                            loadingHide();
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

            }
        });
    })
</script>