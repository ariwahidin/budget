<?php
// var_dump(get_proposal_mechanism($number_proposal)->result()[0]->Mechanism);
// var_dump(get_proposal_customer($number_proposal)->result());
// var_dump(get_customer_only($number_proposal));
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <a class="btn bg-orange pull-right" href="<?= base_url($_SESSION['page'] . '/showProposalDetail/' . $number_proposal) ?>" style="margin-right:5px;">Back</a>
        <h1>Edit Proposal</h1>
    </section>
    <section class="content">
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
                                <td>&nbsp;:&nbsp;<b><?= number_format(get_balance(get_proposal($number_proposal)->row()->BrandCode, $budget_code_activity, get_proposal($number_proposal)->row()->EndDatePeriode, $budget_type, $number_proposal)) ?></b></td>
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
                        <button onclick="showModalItem('<?= get_proposal($number_proposal)->row()->BrandCode ?>')" class="btn btn-primary">Pilih Item</button>
                    </div>
                    <div class="box-body">
                        <table class="table table-responseive table-bordered">
                            <thead>
                                <tr>
                                    <!-- <th>Item Code</th> -->
                                    <th>Barcode</th>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th><?= get_proposal($number_proposal)->row()->AvgSales ?> (Qty)</th>
                                    <th>Sales Estimation (Qty)</th>
                                    <th>Target</th>
                                    <th>Promo(%)</th>
                                    <th>Value Promo</th>
                                    <th>Costing</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyItem">
                                <?php foreach (get_proposal_item($number_proposal)->result() as $item) { ?>
                                    <tr>
                                        <td class="barcode_item">
                                            <?= get_item($item->ItemCode)->row()->FRGNNAME ?>
                                            <input type="hidden" class="itemCode_item" value="<?= $item->ItemCode ?>">
                                        </td>
                                        <td class="itemName_item">
                                            <?= get_item($item->ItemCode)->row()->ITEMNAME ?>
                                        </td>
                                        <td class="td_price_item">
                                            <input onkeyup="calculate(this)" readonly="readonly" class="form-control input_price" value="<?= number_format($item->Price) ?>">
                                        </td>
                                        <td>
                                            <input onkeypress="javascript:return isNumber(event)" onkeyup="formatNumber(this)" readonly="readonly" class="form-control input_avg_sales" value="<?= $item->AvgSales ?>">
                                        </td>
                                        <td class="td_qty_item">
                                            <input onkeypress="javascript:return isNumber(event)" onkeyup="calculate(this);formatNumber(this);calculateValuePromo(this);" class="form-control input_qty" value="<?= $item->Qty ?>">
                                        </td>
                                        <td class="td_target_item">
                                            <input readonly="readonly" class="form-control input_target" value="<?= number_format($item->Target) ?>">
                                        </td>
                                        <td class="td_promo_item">
                                            <input onkeyup="calculate(this)" readonly="readonly" class="form-control input_promo" value="<?= $item->Promo ?>">
                                        </td>
                                        <td>
                                            <input onkeyup="calculateValuePromo(this);formatNumber(this)" onkeypress="javascript:return isNumber(event)" class="form-control input_value_promo" value="<?= number_format($item->PromoValue) ?>">
                                        </td>
                                        <td class="td_costing_item">
                                            <input readonly="readonly" class="form-control input_costing" value="<?= number_format($item->Costing) ?>">
                                        </td>
                                        <td>
                                            <button onclick="deleteRow(this)" class="btn btn-danger btn-xs">Delete</button>
                                        </td>
                                    </tr>
                                <?php } ?>
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
                                <?php foreach (get_proposal_customer($number_proposal)->result() as $customer) { ?>
                                    <tr>
                                        <td class="CustomerCode_Customer">
                                            <?= $customer->CustomerCode ?>
                                            <input type="hidden" class="input_group" value="<?= $customer->GroupCustomer ?>">
                                            <input type="hidden" class="input_customer" value="<?= $customer->CustomerCode ?>">
                                        </td>
                                        <td class="GroupName_Customer"><?= getgroupName($customer->GroupCustomer) ?></td>
                                        <td class="CustomerName_Customer"><?= getCustomerName($customer->CustomerCode) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button onclick="save_changes()" class="btn btn-primary pull-right">Simpan</button>
            </div>
        </div>
    </section>
</div>
<div id="showModalItem"></div>
<?php $this->view('footer'); ?>
<script>
    calculateTotalCosting()
    calculate_total_target()

    function showModalItem(brand) {
        loadingShow();
        var avg_sales = '<?= get_proposal($number_proposal)->row()->AvgSales ?>';
        var customer_code = "<?= get_customer_only($number_proposal) ?>";
        var start_date = '<?= get_proposal($number_proposal)->row()->StartDatePeriode ?>';
        $('#showModalItem').load('<?= base_url($_SESSION['page'] . '/showModalItemFromPenjualan') ?>', {
            brand,
            customer_code,
            start_date,
            avg_sales,
        });
    }

    function calculate_total_target() {
        var input_target = document.querySelectorAll('input.input_target');
        var input_total_target = document.getElementById('total_target');
        var total_target = 0;
        for (var i = 0; i < input_target.length; i++) {
            total_target += parseFloat(input_target[i].value);
        }
        input_total_target.value = money(total_target);
    }

    function deleteRow(e) {
        e.parentElement.parentElement.remove();
        calculate(e)
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

    function calculateValuePromo(elem) {
        var rows = elem.parentElement.parentElement;
        var promo_value = parseFloat(rows.querySelector('input.input_value_promo').value.replace(/,/g, ''));
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

    function money(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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


    function save_changes() {
        var input_group = document.querySelectorAll('input.input_group');
        var input_customer = document.querySelectorAll('input.input_customer');
        var group_code = [];
        var customer_code = [];
        for (var y = 0; y < input_customer.length; y++) {
            group_code.push(input_group[y].value);
            customer_code.push(input_customer[y].value);
        }
        var item_code = [];
        var item_price = [];
        var item_avg_sales = [];
        var item_qty = [];
        var item_target = [];
        var item_promo = [];
        var item_promo_value = [];
        var item_costing = [];
        var total_costing = $('#total_costing').val().replace(/,/g, '');

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


        var budget_saldo = '<?= get_balance(get_proposal($number_proposal)->row()->BrandCode, $budget_code_activity, get_proposal($number_proposal)->row()->EndDatePeriode, $budget_type, $number_proposal) ?>';
        if (parseFloat(total_costing) > parseFloat(budget_saldo)) {
            // alert('Total costing melebihi balance')
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Budget tidak cukup',
            })
            return false;
        }

        $.post("<?= base_url($_SESSION['page']) . '/editProposal' ?>", {
            proposal_number: '<?= $number_proposal ?>',
            brand: '<?= get_proposal($number_proposal)->row()->BrandCode ?>',
            activity: '<?= get_proposal($number_proposal)->row()->Activity ?>',
            start_date: '<?= get_proposal($number_proposal)->row()->StartDatePeriode ?>',
            end_date: '<?= get_proposal($number_proposal)->row()->EndDatePeriode ?>',
            budget_code: '<?= get_proposal($number_proposal)->row()->BudgetCode ?>',
            budget_code_activty: '<?= get_proposal($number_proposal)->row()->BudgetCodeActivity ?>',
            group_code,
            customer_code,
            avg_sales_type: '<?= get_proposal($number_proposal)->row()->AvgSales ?>',
            item_code,
            item_price,
            item_avg_sales,
            item_qty,
            item_target,
            item_promo,
            item_promo_value,
            item_costing,
            customer_code,
            budget_saldo,
            total_costing,
            objective,
            mechanism,
            comment,
            claim_to: '<?= get_proposal($number_proposal)->row()->ClaimTo ?>',
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