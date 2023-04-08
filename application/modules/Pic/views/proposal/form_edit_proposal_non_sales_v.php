<?php
// var_dump($_POST);
// var_dump($budget_type);
// var_dump(get_balance(get_proposal($number_proposal)->row()->BrandCode, $budget_code_activity, get_proposal($number_proposal)->row()->EndDatePeriode, $budget_type, $number_proposal));
// die;
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <a class="btn bg-orange pull-right" href="<?= base_url($_SESSION['page'] . '/showProposalDetail/' . $number_proposal) ?>" style="margin-right:5px;">Back</a>
        <h1>Edit Proposal</h1>
        <section class="content">
        </section>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <table>
                            <tr>
                                <td>No Proposal</td>
                                <td>&nbsp;:&nbsp;<b><?= $number_proposal ?></b></td>
                            </tr>
                            <tr>
                                <td>Brand</td>
                                <td>&nbsp;:&nbsp;<b><?= getBrandName(get_proposal($number_proposal)->row()->BrandCode) ?></b></td>
                            </tr>
                            <tr>
                                <td>Activity</td>
                                <td>&nbsp;:&nbsp;<b><?= getActivityName(get_proposal($number_proposal)->row()->Activity) ?></b></td>
                            </tr>
                            <tr>
                                <td>Start Periode</td>
                                <td>&nbsp;:&nbsp;<b><?= date('d-M-Y', strtotime(get_proposal($number_proposal)->row()->StartDatePeriode)) ?></b></td>
                            </tr>
                            <tr>
                                <td>End Periode</td>
                                <td>&nbsp;:&nbsp;<b><?= date('d-M-Y', strtotime(get_proposal($number_proposal)->row()->EndDatePeriode)) ?></b></td>
                            </tr>
                            <tr>
                                <td>Claim to</td>
                                <td>&nbsp;:&nbsp;<b><?= ucwords(get_proposal($number_proposal)->row()->ClaimTo) ?></b></td>
                            </tr>
                            <tr>
                                <td>Booked</td>
                                <td>&nbsp;:&nbsp;<b><?= number_format(get_budget_booked($budget_code_activity, $budget_type)->row()->budget_booked) ?></b></td>
                            </tr>
                            <tr>
                                <td>Allocated</td>
                                <td>&nbsp;:&nbsp;<b><?= number_format(get_budget_allocated($budget_code_activity, $budget_type)->row()->budget_allocated) ?></b></td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td>&nbsp;:&nbsp;<b><?= $balance = number_format(get_balance(get_proposal($number_proposal)->row()->BrandCode, $budget_code_activity, get_proposal($number_proposal)->row()->EndDatePeriode, $budget_type, $number_proposal)) ?></b></td>
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
                        <!-- <button onclick="showModalCustomer()" class="btn btn-primary">Pilih Customer</button> -->
                    </div>
                    <div class="box-body">
                        <table class="table table-responseive table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer Code</th>
                                    <th>Group Name</th>
                                    <th>Customer Name</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody id="tbodyCustomer">
                                <?php foreach (get_proposal_customer($number_proposal)->result() as $customer) { ?>
                                    <tr>
                                        <td class="CustomerCode_Customer"><?= $customer->CustomerCode ?>
                                            <input type="hidden" class="input_customer" value="<?= $customer->CustomerCode ?>">
                                            <input type="hidden" class="input_group" value="<?= $customer->GroupCustomer ?>">
                                        </td>
                                        <td class="GroupName_Customer"><?= getGroupName($customer->GroupCustomer) ?></td>
                                        <td class="CustomerName_Customer"><?= getCustomerName($customer->CustomerCode) ?></td>
                                        <!-- <td><button onclick="deleteRowCustomer(this)" class="btn btn-danger btn-xs">Delete</button></td> -->
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
                        <button onclick="showModalItem('<?= get_proposal($number_proposal)->row()->BrandCode ?>')" class="btn btn-primary">Pilih Item</button>
                    </div>
                    <div class="box-body">
                        <tfooter>
                        </tfooter>
                        <table class="table table-responseive table-bordered">
                            <thead>
                                <tr>
                                    <!-- <th>Item Code</th> -->
                                    <th>Barcode</th>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th style="display:none;">none</th>
                                    <th>Qty</th>
                                    <th>Target</th>
                                    <th style="display:none;">Promo(%)</th>
                                    <th>Listing Cost</th>
                                    <th>Costing</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyItem">
                                <?php foreach (get_proposal_item($number_proposal)->result() as $item) { ?>
                                    <tr>
                                        <td class="barcode_item"><?= get_item($item->ItemCode)->row()->FRGNNAME ?><input type="hidden" class="itemCode_item" value="<?= $item->ItemCode ?>"></td>
                                        <td class="itemName_item"><?= get_item($item->ItemCode)->row()->ITEMNAME ?></td>
                                        <td class="td_price_item">
                                            <input onkeyup="calculate(this)" class="form-control input_price" value="<?= number_format($item->Price) ?>">
                                        </td>
                                        <td style="display:none;">
                                            <input onkeypress="javascript:return isNumber(event)" onkeyup="formatNumber(this)" readonly="readonly" class="form-control input_avg_sales">
                                        </td>
                                        <td class="td_qty_item">
                                            <input onkeypress="javascript:return isNumber(event)" onkeyup="calculate(this);formatNumber(this)" class="form-control input_qty" value="<?= number_format($item->Qty) ?>">
                                        </td>
                                        <td class=" td_target_item">
                                            <input readonly="readonly" class="form-control input_target" value="<?= number_format($item->Target) ?>">
                                        </td>
                                        <td style="display:none;" class="td_promo_item"><input onkeyup="calculate(this)" readonly="readonly" class="form-control input_promo"></td>
                                        <td>
                                            <input onkeypress="javascript:return isNumber(event)" onkeyup="calculateTotalCosting();formatNumber(this);calculateCost(this);" class="form-control input_cost" value="<?= number_format($item->ListingCost) ?>">
                                        </td>
                                        <td class="td_costing_item">
                                            <input onkeypress="javascript:return isNumber(event)" onkeyup="calculateTotalCosting();formatNumber(this)" readonly="readonly" class="form-control input_costing" value="<?= number_format($item->Costing) ?>">
                                        </td>
                                        <td>
                                            <button onclick="deleteRow(this)" class="btn btn-danger btn-xs">Delete</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tbody>
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
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Cost Ratio</td>
                                    <td>&nbsp;:&nbsp;<span id="span_cost_ratio">0%</span></td>
                                </tr>
                            </tbody>
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
                                            <input type="text" class="form-control input_objective" value="<?= array_key_exists($i, get_proposal_objective($number_proposal)->result()) ? get_proposal_objective($number_proposal)->result()[$i]->Objective : '' ?>">
                                        </td>
                                        <td style="padding:0 !important;">
                                            <input type="text" class="form-control input_mechanism" value="<?= array_key_exists($i, get_proposal_mechanism($number_proposal)->result()) ? get_proposal_mechanism($number_proposal)->result()[$i]->Mechanism : '' ?>">
                                        </td>
                                        <td style="padding:0 !important;">
                                            <input type="text" class="form-control input_comment" value="<?= array_key_exists($i, get_proposal_comment($number_proposal)->result()) ? get_proposal_comment($number_proposal)->result()[$i]->Comment : '' ?>">
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
                <button onclick="updateProposal()" class="btn btn-primary pull-right">Simpan</button>
            </div>
        </div>

    </section>
</div>
<div id="showModalItem"></div>
<div id="showModalCustomer"></div>
<?php $this->view('proposal/modal_set_promo') ?>
<?php $this->view('footer'); ?>
<script>
    calculateTotalCosting();
    calculate_total_target();

    function calculate_total_target() {
        var input_target = document.querySelectorAll('input.input_target');
        var input_total_target = document.getElementById('total_target');
        var total_target = 0;
        for (var i = 0; i < input_target.length; i++) {
            total_target += parseFloat(normalNumber(input_target[i].value));
        }
        input_total_target.value = money(total_target);
    }

    function normalNumber(x) {
        return parseFloat(x.replace(/,/g, ''));
    }

    function money(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function showModalItem(brand) {
        $('#showModalItem').load('<?= base_url($_SESSION['page'] . '/showModalItemForListing') ?>', {
            brand
        });
    }

    function deleteRow(e) {
        e.parentElement.parentElement.remove();
        calculateCostingOtomatis();
        calculate(e)
        calculateTotalCosting()
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

    function updateProposal() {
        var proposal_bumber;
        var input_group = document.querySelectorAll('input.input_group');
        var input_customer = document.querySelectorAll('input.input_customer');
        var group_code = [];
        var customer_code = [];
        for (var y = 0; y < input_customer.length; y++) {
            group_code.push(input_group[y].value);
            customer_code.push(input_customer[y].value);
        }

        var brand = '<?= get_proposal($number_proposal)->row()->BrandCode ?>';
        var activity = '<?= get_proposal($number_proposal)->row()->Activity ?>';
        var start_date = '<?= get_proposal($number_proposal)->row()->StartDatePeriode ?>';
        var end_date = '<?= get_proposal($number_proposal)->row()->EndDatePeriode ?>';
        var budget_code = '<?= get_proposal($number_proposal)->row()->BudgetCode ?>';
        var budget_saldo = normalNumber('<?= get_balance(get_proposal($number_proposal)->row()->BrandCode, $budget_code_activity, get_proposal($number_proposal)->row()->EndDatePeriode, $budget_type, $number_proposal) ?>');
        var avg_sales_type = '<?= get_proposal($number_proposal)->row()->AvgSales ?>';
        var claim_to = '<?= get_proposal($number_proposal)->row()->ClaimTo ?>';
        var item_code = [];
        var item_price = [];
        var item_avg_sales = [];
        var item_qty = [];
        var item_target = [];
        var item_promo = [];
        var item_costing = [];
        var listing_cost = [];
        var total_costing = $('#total_costing').val().replace(/,/g, '');

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

        var td_customer_code = document.querySelectorAll('td.CustomerCode_Customer');

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
            //alert('Semua wajib diisi dengan benar');
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Input cannot be empty',
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

        if (parseFloat(total_costing) > parseFloat(budget_saldo)) {
            //alert('Total costing melebihi balance')
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Balance is not enough',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        $.post("<?= base_url($_SESSION['page']) . '/editProposal' ?>", {
            proposal_number: '<?= $number_proposal ?>',
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
            budget_saldo,
            total_costing,
            objective,
            mechanism,
            comment,
            claim_to,
            budget_type: '<?= $budget_type ?>',
        }, function(result) {
            if (result.success == true) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Proposal berhasil diupdate',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location.href = "<?= base_url($_SESSION['page'] . '/showProposalDetail/') . $number_proposal ?>";
                })
            }
        }, 'json');
    }
</script>