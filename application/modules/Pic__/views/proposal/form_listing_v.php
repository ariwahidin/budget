<?php
// var_dump($_POST);
// die;
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Create Proposal Listing</h1>
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
                                <td>&nbsp;:&nbsp;<b><?= date('d-M-Y', strtotime($_POST['start_date'])) ?></b></td>
                            </tr>
                            <tr>
                                <td>End Periode</td>
                                <td>&nbsp;:&nbsp;<b><?= date('d-M-Y', strtotime($_POST['end_date'])) ?></b></td>
                            </tr>
                            <tr>
                                <td>Group Customer </td>
                                <td>&nbsp;:&nbsp;<b><?= getGroupName($_POST['group']) ?></b></td>
                            </tr>
                            <tr>
                                <td>YTD Operating Budget</td>
                                <td>&nbsp;:&nbsp;<b><?= number_format($_POST['ytd_operating_budget_activity']) ?></b></td>
                            </tr>
                            <tr>
                                <td>YTD Actual Budget</td>
                                <td>&nbsp;:&nbsp;<b><?= number_format($_POST['ytd_actual_budget']) ?></b></td>
                            </tr>
                            <tr>
                                <td>Booked</td>
                                <td>&nbsp;:&nbsp;<b><?= number_format($_POST['ytd_allocated_budget']) ?></b></td>
                            </tr>
                            <tr>
                                <?php
                                $real_budget = 0;
                                if ($_POST['ytd_actual_budget'] < $_POST['ytd_operating_budget_activity']) {
                                    $real_budget = (float)$_POST['ytd_actual_budget'] - (float)$_POST['ytd_allocated_budget'];
                                } else {
                                    $real_budget = (float)$_POST['ytd_operating_budget_activity'] - (float)$_POST['ytd_allocated_budget'];
                                }
                                ?>
                                <td>Balance</td>
                                <td>&nbsp;:&nbsp;<b><?= number_format($real_budget) ?></b></td>
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
                                    <th style="display:none;"><?= $_POST['avg_sales'] ?></th>
                                    <th>Qty</th>
                                    <th>Target</th>
                                    <th style="display:none;">Promo(%)</th>
                                    <th>Listing Cost</th>
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
                                    <!-- <td></td> -->
                                    <td id="totalPrice"></td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control" id="total_target" readonly="readonly">
                                    </td>
                                    <td style="display:none;"></td>
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
    $(document).ready(function() {
        calculate_cost_ratio();
    });

    function showModalItem(brand) {
        $('#showModalItem').load('<?= base_url($_SESSION['page'] . '/showModalItemForListing') ?>', {
            brand
        });
    }

    function showModalCustomer(group) {
        $('#showModalCustomer').load('<?= base_url($_SESSION['page'] . '/showModalCustomerForListing') ?>', {
            group
        });
    }

    function deleteRow(e) {
        e.parentElement.parentElement.remove();
        calculateCostingOtomatis();
        calculate(e)
        calculateTotalCosting()
    }

    function deleteRowCustomer(e) {
        e.parentElement.parentElement.remove();
        calculateCostingOtomatis()
        calculateTotalCosting()
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

    function calculateCost(elem) {
        var customer = document.querySelectorAll(".CustomerCode_Customer");
        var jumlah_customer = 0;
        var elem_value = elem.value;
        var input_costing = elem.parentElement.parentElement.querySelector(".input_costing");

        if (customer.length > 0) {
            jumlah_customer = customer.length;
        }

        elem_value = parseFloat(elem_value.replace(/,/g, '')) * jumlah_customer;
        input_costing.value = !isNaN(elem_value) ? elem_value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
        calculateCostingOtomatis()
        calculateTotalCosting()
    }

    function calculateTotalCosting() {
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

    function calculateCostingOtomatis() {
        var input_cost = document.querySelectorAll("input.input_cost");
        var input_costing = document.querySelectorAll("input.input_costing");
        var customer = document.querySelectorAll("td.CustomerCode_Customer");
        var jumlah_customer = 0;
        var listing_cost = 0;

        if (customer.length > 0) {
            jumlah_customer = customer.length;
        }

        for (var i = 0; i < input_cost.length; i++) {
            listing_cost = parseFloat(input_cost[i].value.replace(/,/g, '')) * jumlah_customer
            input_costing[i].value = listing_cost.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    }

    function calculate(e) {
        var row = e.parentElement.parentElement;
        var inputPrice = row.querySelector('input.input_price');
        inputPrice.value = inputPrice.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var inputQty = row.querySelector('input.input_qty');
        var inputTarget = row.querySelector('input.input_target');

        var inputPromo = row.querySelector('input.input_promo');
        inputPromo.value = !isNaN(parseFloat(inputPromo.value)) ? parseFloat(inputPromo.value) : 0;

        var target = 0;
        target = parseFloat(inputPrice.value.replace(/,/g, '')) * parseFloat(inputQty.value.replace(/,/g, ''));
        inputTarget.value = !isNaN(target) ? target.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;

        var all_input_target = document.querySelectorAll('input.input_target');
        var total_target = 0;
        for (var i = 0; i < all_input_target.length; i++) {
            total_target += parseFloat(all_input_target[i].value.replace(/,/g, ''));
        }
        var input_total_target = document.getElementById('total_target');
        input_total_target.value = !isNaN(parseFloat(total_target)) ? total_target.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
        calculate_cost_ratio();
        calculateTotalCosting()
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
        var real_budget = '<?= $real_budget ?>';
        var avg_sales_type = '<?= $_POST['avg_sales'] ?>';
        var claim_to = '<?= $_POST['claim_to'] ?>';
        var item_code = [];
        var item_price = [];
        var item_avg_sales = [];
        var item_qty = [];
        var item_target = [];
        var item_promo = [];
        var item_costing = [];
        var listing_cost = [];
        var total_costing = $('#total_costing').val().replace(/,/g, '');
        var YTD_operating = '<?= $_POST['ytd_operating_budget_activity'] ?>';
        var YTD_purchase = '<?= $_POST['ytd_actual_budget'] ?>';

        var input_item_code = document.querySelectorAll('input.itemCode_item');
        var input_price = document.querySelectorAll('input.input_price');
        var input_avg_sales = document.querySelectorAll('input.input_avg_sales');
        var input_qty = document.querySelectorAll('input.input_qty');
        var input_target = document.querySelectorAll('input.input_target');
        var input_promo = document.querySelectorAll('input.input_promo');
        var input_costing = document.querySelectorAll('input.input_costing');
        var input_listing_cost = document.querySelectorAll('input.input_cost');

        var input_objective = document.querySelectorAll('input.input_objective');
        var input_mechanism = document.querySelectorAll('input.input_mechanism');
        var input_comment = document.querySelectorAll('input.input_comment');
        var objective = [];
        var mechanism = [];
        var comment = [];

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

        for (var x = 0; x < input_item_code.length; x++) {
            item_code.push(input_item_code[x].value);
            item_price.push(input_price[x].value.replace(/,/g, ''));
            item_avg_sales.push(input_avg_sales[x].value.replace(/,/g, ''));
            item_qty.push(input_qty[x].value.replace(/,/g, ''));
            item_target.push(input_target[x].value.replace(/,/g, ''));
            item_promo.push(input_promo[x].value.replace(/,/g, ''));
            item_costing.push(input_costing[x].value.replace(/,/g, ''));
            listing_cost.push(input_listing_cost[x].value.replace(/,/g, ''));
        }

        const duplicates = item_code.filter((item, index) => index !== item_code.indexOf(item));
        if (duplicates.length > 0) {
            //alert("Item tidak boleh sama");
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Item cannot be the same',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }


        // var customer_code = [];
        var td_customer_code = document.querySelectorAll('td.CustomerCode_Customer');
        // for (var c = 0; c < td_customer_code.length; c++) {
        //     customer_code.push(td_customer_code[c].innerText);
        // }

        const duplicates_customer = customer_code.filter((item, index) => index !== customer_code.indexOf(item));
        if (duplicates_customer.length > 0) {
            //alert("Customer tidak boleh sama");
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Customer cannot be the same',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if (total_costing == '' || total_costing == 0) {
            // alert('Semua wajib diisi dengan benar');
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Your input is not correct',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        } else if (td_customer_code.length < 1) {
            //alert('Customer belum diisi');
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Customer cannot be empty',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false
        }

        if (parseFloat(total_costing) > parseFloat(real_budget)) {
            // alert('Total costing melebihi balance')
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Balance is not enough',
                // footer: '<a href="">Why do I have this issue?</a>'
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
            avg_sales_type,
            item_code,
            item_price,
            item_avg_sales,
            item_qty,
            item_target,
            item_promo,
            item_costing,
            listing_cost,
            customer_code,
            real_budget,
            total_costing,
            YTD_operating,
            YTD_purchase,
            objective,
            mechanism,
            comment,
            claim_to
        }, function(result) {
            if (result.success == true) {
                window.location.href = "<?= base_url($_SESSION['page']) . '/showProposal' ?>";
            }
        }, 'json');
    }
</script>