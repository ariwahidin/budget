<?php
// var_dump($budget_type);

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
                        <a href="javascript:history.go(-1)" class="btn btn-warning pull-right">Back</a>
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
                                <td>&nbsp;:&nbsp;<b><?= date('d-M-Y', strtotime($_POST['start_date'])) ?></b></td>
                            </tr>
                            <tr>
                                <td>End Periode</td>
                                <td>&nbsp;:&nbsp;<b><?= date('d-M-Y', strtotime($_POST['end_date'])) ?></b></td>
                            </tr>
                            <tr>
                                <td>Claim to</td>
                                <td>&nbsp;:&nbsp;<b><?= ucfirst($_POST['claim_to']) ?></b></td>
                            </tr>
                            <tr>
                                <td>YTD Operating Budget</td>
                                <td>&nbsp;:&nbsp;<b><?= $_POST['budget_activity'] ?></b></td>
                            </tr>
                            <tr>
                                <td>YTD Actual Budget</td>
                                <td>&nbsp;:&nbsp;<b><?= $_POST['budget_actual'] ?></b></td>
                            </tr>
                            <tr>
                                <td>Booked</td>
                                <td>&nbsp;:&nbsp;<b><?= $_POST['budget_booked'] ?></b></td>
                            </tr>
                            <tr>
                                <td>Unbooked</td>
                                <td>&nbsp;:&nbsp;<b><?= $_POST['allocated_budget'] ?></b></td>
                            </tr>
                            <tr>
                                <td>IMS <?= !empty($_POST['ims']) ? '(Used)' : '' ?></td>
                                <td>&nbsp;:&nbsp;<b><?= $_POST['ims_value'] ?></b></td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td>&nbsp;:&nbsp;<b><?= $_POST['balance_budget'] ?></b></td>
                            </tr>
                            <tr>
                                <td>Total Costing</td>
                                <td>&nbsp;:&nbsp;<b id="td_total_costing"></b></td>
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
                                    <th><?= $_POST['avg_sales'] ?> (Qty)</th>
                                    <th>Sales Estimation (Qty)</th>
                                    <th>Target</th>
                                    <th>Promo(%)</th>
                                    <th>Value Promo</th>
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
                                    <td></td>
                                    <td id="totalPrice"></td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control" id="total_target" readonly="readonly">
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control" id="total_costing" readonly="readonly">
                                    </td>
                                    <td></td>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                    <div class="box-footer">
                        <table>
                            <tr>
                                <td>Cost Ratio</td>
                                <td>&nbsp;:&nbsp;<span id="span_cost_ratio"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header"></div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Objective</th>
                                    <th>Mechanism</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < 5; $i++) { ?>
                                    <tr>
                                        <td style="padding:0 !important;">
                                            <input type="text" class="form-control input_objective">
                                        </td>
                                        <td style="padding:0 !important;">
                                            <input type="text" class="form-control input_mechanism">
                                        </td>
                                        <td style="padding:0 !important;">
                                            <input type="text" class="form-control input_comment">
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        <table class="table table-responseive table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer Code</th>
                                    <th>Group Name</th>
                                    <th>Customer Name</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyCustomer">
                                <?php for ($i = 0; $i < count($_POST['customer']); $i++) { ?>
                                    <tr>
                                        <td class="CustomerCode_Customer">
                                            <?= $_POST['customer'][$i] ?>
                                            <input type="hidden" class="input_group" value="<?= $_POST['group'][$i] ?>">
                                            <input type="hidden" class="input_customer" value="<?= $_POST['customer'][$i] ?>">
                                        </td>
                                        <td class="GroupName_Customer"><?= getGroupName($_POST['group'][$i]) ?></td>
                                        <td class="CustomerName_Customer"><?= getCustomerName($_POST['customer'][$i]) ?></td>
                                    </tr>
                                <?php } ?>
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
<?php
$customer_code = implode("','", $_POST['customer']);
$group_code = implode("','", $_POST['group']);
// var_dump($customer_code);
?>

<script>
    $(document).ready(function() {
        calculate_cost_ratio();
    });

    function showModalItem(brand) {
        loadingShow();
        var avg_sales = '<?= $_POST['avg_sales'] ?>';
        var customer_code = "'<?= $customer_code ?>'";
        var start_date = '<?= $_POST['start_date'] ?>';
        $('#showModalItem').load('<?= base_url($_SESSION['page'] . '/showModalItemFromPenjualan') ?>', {
            brand,
            customer_code,
            start_date,
            avg_sales,
        });
    }

    function showModalCustomer(group) {
        $('#showModalCustomer').load('<?= base_url($_SESSION['page'] . '/showModalCustomer') ?>', {
            group
        });
    }

    function deleteRow(e) {
        e.parentElement.parentElement.remove();
        calculate(e)
    }

    function deleteRowCustomer(e) {
        e.parentElement.parentElement.remove();
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function formatNumber(num) {
        var value = num.value.replace(/,/g, '');
        value = parseFloat(value);
        return num.value = isNaN(value) ? '' : value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function calculateValuePromo(elem) {
        var promo_value = parseFloat(elem.value.replace(/,/g, ''));
        var rows = elem.parentElement.parentElement;
        var input_promo = rows.querySelector('input.input_promo');
        var input_qty = parseFloat(rows.querySelector('input.input_qty').value.replace(/,/g, ''));
        var input_price = parseFloat(rows.querySelector('input.input_price').value.replace(/,/g, ''));
        var promo = 0;
        var input_costing = rows.querySelector('input.input_costing');
        var costing = 0;
        costing = (promo_value * input_qty);
        promo = Math.round((promo_value / input_price) * 100);
        input_promo.value = !isNaN(promo) ? promo : 0;
        input_costing.value = !isNaN(costing) ? money(costing) : 0;
        calculate_cost_ratio()
        calculateTotalCosting()
    }

    function calculateTotalCosting() {
        var input_total_costing = document.getElementById('total_costing');
        var input_costing = document.querySelectorAll('input.input_costing');
        var td_total_costing = document.getElementById('td_total_costing');
        var total_costing = 0;
        for (var i = 0; i < input_costing.length; i++) {
            if (!isNaN(normalNumber(input_costing[i].value))) {
                total_costing += normalNumber(input_costing[i].value);
            }
        }
        input_total_costing.value = !isNaN(total_costing) ? money(total_costing) : 0;
        td_total_costing.innerText = !isNaN(total_costing) ? money(total_costing) : 0;
        calculate_cost_ratio();
    }

    function normalNumber(x) {
        return parseFloat(x.replace(/,/g, ''));
    }

    function money(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function calculate(e) {
        var row = e.parentElement.parentElement;
        var inputPrice = row.querySelector('input.input_price');
        inputPrice.value = inputPrice.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var inputQty = row.querySelector('input.input_qty');
        var inputTarget = row.querySelector('input.input_target');
        var inputPromo = row.querySelector('input.input_promo');
        inputPromo.value = !isNaN(parseFloat(inputPromo.value)) ? parseFloat(inputPromo.value) : 0;
        var inputCosting = row.querySelector('input.input_costing');
        var costing = 0;
        costing = ((inputPromo.value / 100) * inputPrice.value.replace(/,/g, '')) * parseFloat(inputQty.value.replace(/,/g, ''));
        inputCosting.value = !isNaN(parseFloat(costing)) ? Math.round(costing).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;

        var target = 0;
        target = parseFloat(inputPrice.value.replace(/,/g, '')) * parseFloat(inputQty.value.replace(/,/g, ''));
        inputTarget.value = !isNaN(target) ? Math.round(target).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;

        var all_input_target = document.querySelectorAll('input.input_target');
        var total_target = 0;
        for (var i = 0; i < all_input_target.length; i++) {
            total_target += parseFloat(all_input_target[i].value.replace(/,/g, ''));
        }
        var input_total_target = document.getElementById('total_target');
        input_total_target.value = !isNaN(parseFloat(total_target)) ? total_target.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;

        var all_input_costing = document.querySelectorAll('input.input_costing');
        var total_costing = 0;
        for (var x = 0; x < all_input_costing.length; x++) {
            total_costing += parseFloat(all_input_costing[x].value.replace(/,/g, ''));
        }
        var input_total_costing = document.getElementById('total_costing');
        var td_total_costing = document.getElementById('td_total_costing');
        input_total_costing.value = !isNaN(parseFloat(total_costing)) ? total_costing.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
        td_total_costing.innerText = !isNaN(parseFloat(total_costing)) ? total_costing.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
        calculate_cost_ratio();
    }

    function calculate_cost_ratio() {
        var cost_ratio = 0;
        var span_cost_ratio = document.getElementById("span_cost_ratio");
        var total_target = document.getElementById("total_target").value.replace(/,/g, '');
        var total_costing = document.getElementById("total_costing").value.replace(/,/g, '');
        cost_ratio = (parseFloat(total_costing) / parseFloat(total_target)) * 100;
        span_cost_ratio.innerText = !isNaN(cost_ratio) ? cost_ratio.toFixed(2) + '%' : 0 + '%';
    }

    function simpanProposal() {
        var input_group = document.querySelectorAll('input.input_group');
        var input_customer = document.querySelectorAll('input.input_customer');
        var group_code = [];
        var customer_code = [];
        for (var y = 0; y < input_customer.length; y++) {
            group_code.push(input_group[y].value);
            customer_code.push(input_customer[y].value);
        }

        var brand = '<?= $_POST['brand'] ?>';
        var activity = '<?= $_POST['activity'] ?>';
        var start_date = '<?= $_POST['start_date'] ?>';
        var end_date = '<?= $_POST['end_date'] ?>';
        var budget_code = '<?= $_POST['budget_code_activity'] ?>';
        var ims_saldo = '<?= str_replace(',', '', $_POST['ims_value']) ?>';
        var budget_saldo = '<?= (float)str_replace(',', '', $_POST['balance_budget']) ?>';
        var avg_sales_type = '<?= $_POST['avg_sales'] ?>';
        var claim_to = '<?= $_POST['claim_to'] ?>';
        var item_code = [];
        var item_price = [];
        var item_avg_sales = [];
        var item_qty = [];
        var item_target = [];
        var item_promo = [];
        var item_promo_value = [];
        var item_costing = [];
        var total_costing = $('#total_costing').val().replace(/,/g, '');
        var YTD_operating = '<?= str_replace(',', '', $_POST['budget_activity']) ?>';
        var YTD_purchase = '<?= str_replace(',', '', $_POST['budget_actual']) ?>';
        var total_budget_activity = '<?= str_replace(',', '', $_POST['total_budget_activity']) ?>';
        var total_operating = '<?= str_replace(',', '', $_POST['total_operating']) ?>';
        var YTD_budget_activity = '<?= str_replace(',', '', $_POST['budget_activity']) ?>';
        var YTD_actual_budget = '<?= str_replace(',', '', $_POST['budget_actual']) ?>';

        var input_item_code = document.querySelectorAll('input.itemCode_item');
        var input_price = document.querySelectorAll('input.input_price');
        var input_avg_sales = document.querySelectorAll('input.input_avg_sales');
        var input_qty = document.querySelectorAll('input.input_qty');
        var input_target = document.querySelectorAll('input.input_target');
        var input_promo = document.querySelectorAll('input.input_promo');
        var input_promo_value = document.querySelectorAll('input.input_value_promo');
        var input_costing = document.querySelectorAll('input.input_costing');

        var input_objective = document.querySelectorAll('input.input_objective');
        var input_mechanism = document.querySelectorAll('input.input_mechanism');
        var input_comment = document.querySelectorAll('input.input_comment');
        var objective = [];
        var mechanism = [];
        var comment = [];

        for (var x = 0; x < input_item_code.length; x++) {
            item_code.push(input_item_code[x].value);
            item_price.push(input_price[x].value.replace(/,/g, ''));
            item_avg_sales.push(input_avg_sales[x].value.replace(/,/g, ''));
            item_qty.push(input_qty[x].value.replace(/,/g, ''));
            item_target.push(input_target[x].value.replace(/,/g, ''));
            item_promo.push(input_promo[x].value.replace(/,/g, ''));
            item_promo_value.push(input_promo_value[x].value.replace(/,/g, ''));
            item_costing.push(input_costing[x].value.replace(/,/g, ''));
        }

        for (var i = 0; i < input_objective.length; i++) {
            if (input_objective[i].value != '') {
                objective.push(input_objective[i].value);
            }
            if (input_mechanism[i].value != '') {
                mechanism.push(input_mechanism[i].value);
            }
            if (input_comment[i].value != '') {
                comment.push(input_comment[i].value);
            }
        }

        const duplicates = item_code.filter((item, index) => index !== item_code.indexOf(item));
        if (duplicates.length > 0) {
            // alert("Item tidak boleh sama");
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Item tidak boleh sama',
            })
            return false;
        }


        var customer_code = [];
        var td_customer_code = document.querySelectorAll('td.CustomerCode_Customer');
        for (var c = 0; c < td_customer_code.length; c++) {
            customer_code.push(td_customer_code[c].innerText);
        }

        const duplicates_customer = customer_code.filter((item, index) => index !== customer_code.indexOf(item));
        if (duplicates_customer.length > 0) {
            // alert("Customer tidak boleh sama");
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Customer tidak boleh sama',
            })
            return false;
        }

        if (total_costing == '' || total_costing == 0) {
            // alert('Semua wajib diisi dengan benar');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Semua wajib di isi dengan benar',
            })
            return false;
        } else if (td_customer_code.length < 1) {
            // alert('Customer belum diisi');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Customer belum diisi',
            })
            return false
        }

        if (parseFloat(total_costing) > parseFloat(budget_saldo)) {
            // alert('Total costing melebihi balance')
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Budget tidak cukup',
            })
            return false;
        }

        $.post("<?= base_url($_SESSION['page']) . '/simpanProposal' ?>", {
            brand,
            activity,
            start_date,
            end_date,
            budget_code,
            group_code,
            customer_code,
            avg_sales_type,
            item_code,
            item_price,
            item_avg_sales,
            item_qty,
            item_target,
            item_promo,
            item_promo_value,
            item_costing,
            customer_code,
            ims_saldo,
            budget_saldo,
            total_costing,
            YTD_operating,
            YTD_purchase,
            YTD_budget_activity,
            YTD_actual_budget,
            objective,
            mechanism,
            comment,
            claim_to,
            total_budget_activity,
            total_operating,
            budget_type: '<?= $budget_type ?>',
        }, function(result) {
            if (result.success == true) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Proposal berhasil Disimpan',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location.href = "<?= base_url($_SESSION['page']) . '/showProposal' ?>";
                })
            }
        }, 'json');
    }
</script>