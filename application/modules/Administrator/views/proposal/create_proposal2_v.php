<?php
var_dump($_SESSION);
// var_dump($number);
// var_dump($Allocated_budget);
// var_dump($YTD_purchase_activity);
// var_dump($_POST)
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Create Proposal</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <table>
                            <tr>
                                <td>No Proposal</td>
                                <td>&nbsp;:&nbsp;<b><?= $number ?></b></td>
                            </tr>
                            <tr>
                                <td>Brand</td>
                                <td>&nbsp;:&nbsp;<b><?= getBrandName($_POST['brand']) ?></b></td>
                            </tr>
                            <tr>
                                <td>Activity</td>
                                <td>&nbsp;:&nbsp;<b><?= getActivityName($_POST['activity']) ?></b></td>
                            </tr>
                            <tr>
                                <td>Start Periode</td>
                                <td>&nbsp;:&nbsp;<b><?= $_POST['start_date'] ?></b></td>
                            </tr>
                            <tr>
                                <td>End Periode</td>
                                <td>&nbsp;:&nbsp;<b><?= $_POST['end_date'] ?></b></td>
                            </tr>
                            <tr>
                                <td>Group Customer </td>
                                <td>&nbsp;:&nbsp;<b><?= getGroupName($_POST['group']) ?></b></td>
                            </tr>
                            <tr>
                                <td>Allocated Budget Activity</td>
                                <td>&nbsp;:&nbsp;<b><?= number_format($Allocated_budget) ?></b></td>
                            </tr>
                            <tr>
                                <td>YTD Operating Activity</td>
                                <td>&nbsp;:&nbsp;<b><?= number_format($_POST['operating']) ?></b></td>
                            </tr>
                            <tr>
                                <td>YTD Purchase Activity</td>
                                <td>&nbsp;:&nbsp;<b><?= number_format($YTD_purchase_activity) ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <button onclick="showModalItem('<?= $_POST['brand'] ?>')" class="btn btn-primary">Pilih Item</button>
                    </div>
                    <div class="box-body">
                        <table class="table table-responseive table-bordered">
                            <thead>
                                <tr>
                                    <!-- <th>Item Code</th> -->
                                    <th>Barcode</th>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Target</th>
                                    <th>Promo(%)</th>
                                    <th>Costing</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyItem">

                            </tbody>
                            <tfooter>
                                <tr>
                                    <!-- <td></td> -->
                                    <td></td>
                                    <td></td>
                                    <td id="totalPrice"></td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control" id="total_target" readonly="readonly">
                                    </td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control" id="total_costing" readonly="readonly">
                                    </td>
                                    <td></td>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <button onclick="showModalCustomer('<?= $_POST['group'] ?>')" class="btn btn-primary">Pilih Customer</button>
                    </div>
                    <div class="box-body">
                        <table class="table table-responseive table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer Code</th>
                                    <th>Group Name</th>
                                    <th>Customer Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyCustomer">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button onclick="simpanProposal()" class="btn btn-primary pull-right">Simpan</button>
            </div>
        </div>

    </section>
</div>
<div id="showModalItem"></div>
<div id="showModalCustomer"></div>
<?php $this->view('proposal/modal_set_promo') ?>
<?php $this->view('footer'); ?>
<script>
    function showModalItem(brand) {
        $('#showModalItem').load('<?= base_url($_SESSION['page'] . '/showModalItem') ?>', {
            brand
        });
    }

    function showModalCustomer(group) {
        $('#showModalCustomer').load('<?= base_url($_SESSION['page'] . '/showModalCustomer') ?>', {
            group
        });
    }

    function sumPrice() {
        var totalPrice = document.querySelector('td#totalPrice');
        var price = document.querySelectorAll('td.price_item');
        var sumPrice = 0;
        for (var i = 0; i < price.length; i++) {
            sumPrice += parseFloat(price[i].innerText);
        }
        totalPrice.innerText = sumPrice;
    }

    function deleteRow(e) {
        e.parentElement.parentElement.remove();
        sumPrice()
        calculate(e)
    }

    function deleteRowCustomer(e) {
        e.parentElement.parentElement.remove();
        sumPrice()
    }

    function calculate(e) {
        var row = e.parentElement.parentElement;
        var inputPrice = row.querySelector('input.input_price');
        inputPrice.value = inputPrice.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var inputQty = row.querySelector('input.input_qty');
        inputQty.value = !isNaN(parseFloat(inputQty.value)) ? parseFloat(inputQty.value) : 0;
        var inputTarget = row.querySelector('input.input_target');
        var inputPromo = row.querySelector('input.input_promo');
        inputPromo.value = !isNaN(parseFloat(inputPromo.value)) ? parseFloat(inputPromo.value) : 0;
        var inputCosting = row.querySelector('input.input_costing');
        var costing = 0;
        costing = ((inputPromo.value / 100) * inputPrice.value.replace(/,/g, '')) * inputQty.value;
        inputCosting.value = !isNaN(parseFloat(costing)) ? costing.toLocaleString() : 0;

        var target = 0;
        target = parseFloat(inputPrice.value.replace(/,/g, '')) * parseFloat(inputQty.value);
        inputTarget.value = !isNaN(target) ? target.toLocaleString() : 0;

        var all_input_target = document.querySelectorAll('input.input_target');
        var total_target = 0;
        for (var i = 0; i < all_input_target.length; i++) {
            total_target += parseFloat(all_input_target[i].value.replace(/,/g, ''));
        }
        var input_total_target = document.getElementById('total_target');
        input_total_target.value = !isNaN(parseFloat(total_target)) ? total_target.toLocaleString() : 0;

        var all_input_costing = document.querySelectorAll('input.input_costing');
        var total_costing = 0;
        for (var x = 0; x < all_input_costing.length; x++) {
            total_costing += parseFloat(all_input_costing[x].value.replace(/,/g, ''));
        }
        var input_total_costing = document.getElementById('total_costing');
        input_total_costing.value = !isNaN(parseFloat(total_costing)) ? total_costing.toLocaleString() : 0;

    }

    // function setPromo(e){
    //     var row = e.parentElement.parentElement;
    //     // console.log(row);
    //     document.querySelector('b#md_item_name').innerText = row.querySelector('td.itemName_item').innerText;
    //     document.querySelector('b#md_barcode').innerText = row.querySelector('td.barcode_item').innerText;
    //     document.querySelector('input#md_price').value = row.querySelector('td.price_item').innerText;
    //     document.querySelector('input#md_qty').value = 0;
    //     document.querySelector('input#md_target').value = 0;
    //     document.querySelector('input#md_promo').value = 0;
    //     document.querySelector('input#md_costing').value = 0;
    //     $('#modal_set_promo').modal('show');
    // }

    function simpanProposal() {
        var brand = '<?= $_POST['brand'] ?>';
        var activity = '<?= $_POST['activity'] ?>';
        var start_date = '<?= $_POST['start_date'] ?>';
        var end_date = '<?= $_POST['end_date'] ?>';
        var budget_code = '<?= $_POST['budget_code'] ?>';
        var operating = '<?= $_POST['operating'] ?>';
        var group_code = '<?= $_POST['group'] ?>';
        var item_code = [];
        var item_price = [];
        var item_qty = [];
        var item_target = [];
        var item_promo = [];
        var item_costing = [];
        var total_costing = $('#total_costing').val().replace(/,/g, '');

        var input_item_code = document.querySelectorAll('input.itemCode_item');
        var input_price = document.querySelectorAll('input.input_price');
        var input_qty = document.querySelectorAll('input.input_qty');
        var input_target = document.querySelectorAll('input.input_target');
        var input_promo = document.querySelectorAll('input.input_promo');
        var input_costing = document.querySelectorAll('input.input_costing');

        for (var x = 0; x < input_item_code.length; x++) {
            item_code.push(input_item_code[x].value);
            item_price.push(input_price[x].value.replace(/,/g, ''));
            item_qty.push(input_qty[x].value.replace(/,/g, ''));
            item_target.push(input_target[x].value.replace(/,/g, ''));
            item_promo.push(input_promo[x].value.replace(/,/g, ''));
            item_costing.push(input_costing[x].value.replace(/,/g, ''));
        }

        var customer_code = [];
        var td_customer_code = document.querySelectorAll('td.CustomerCode_Customer');
        for (var c = 0; c < td_customer_code.length; c++) {
            customer_code.push(td_customer_code[c].innerText);
        }

        if(total_costing == '' || total_costing == 0){
            alert('Semua wajib diisi dengan benar');
            return false;
        }else if(td_customer_code.length < 1){
            alert('Customer belum diisi');
            return false
        }

        $.post("<?= base_url($_SESSION['page']) . '/simpanProposal' ?>", {
            brand,
            activity,
            start_date,
            end_date,
            budget_code,
            group_code,
            item_code,
            item_price,
            item_qty,
            item_target,
            item_promo,
            item_costing,
            customer_code,
            operating,
            total_costing
        }, function(result) {
            if (result.success == true) {
                window.location.href = "<?= base_url($_SESSION['page']) . '/showProposal' ?>";
            }
        }, 'json');
    }
</script>