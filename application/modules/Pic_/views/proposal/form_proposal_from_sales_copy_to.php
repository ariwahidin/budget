<?php
// var_dump($group_customer->result());
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
                <h4>Create Proposal</h4>
            </div>
            <div class="col-md-6">
                <a href="javascript:history.go(-1)" class="btn btn-warning pull-right">Back</a>
            </div>
        </div>

    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">

                    <div class="box-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No. Proposal</th>
                                    <th style="width:200px; display:none">No. Doc</th>
                                    <th>Brand</th>
                                    <th>Activity</th>
                                    <th>Start Periode</th>
                                    <th>End Periode</th>
                                    <th>Claim to</th>
                                    <th style="display: none;">Booked</th>
                                    <th style="display: none;">Unbooked</th>
                                    <th>Balance</th>
                                    <th>Total Costing</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td><?= $number ?></td>
                                    <td style="display: none;">
                                        <input id="no-doc" type="text" class="form-control" value="<?= $no_doc ?>" readonly>
                                    </td>
                                    <td><?= getBrandName($_POST['brand']) ?></td>
                                    <td><?= getActivityName($_POST['activity']) ?></td>
                                    <td><?= date('d-M-Y', strtotime($_POST['start_date'])) ?></td>
                                    <td><?= date('d-M-Y', strtotime($_POST['end_date'])) ?></td>
                                    <td><?= ucfirst($_POST['claim_to']) ?></td>
                                    <td style="display: none;"><?= $_POST['budget_activity'] ?></td>
                                    <td style="display: none;"><?= $_POST['budget_booked'] ?></td>
                                    <td><?= $_POST['balance_budget'] ?></td>
                                    <td><b id="td_total_costing"></b></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="display: none;">
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
                            <tr style="display:none;">
                                <td>YTD Operating Budget</td>
                                <td>&nbsp;:&nbsp;<b><?= $_POST['budget_activity'] ?></b></td>
                            </tr>
                            <tr style="display:none;">
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
                                <td>&nbsp;:&nbsp;</td>
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
                        <div class="row">
                            <div class="col col-md-4">
                                <button onclick="showModalItem('<?= $_POST['brand'] ?>')" class="btn btn-primary btn_pilih_product">Pilih Product</button>
                            </div>
                            <div class="col col-md-4 text-center">
                                <h4><b>TABEL PRODUCT</b></h4>
                            </div>
                            <div class="col col-md-4">
                                <button onclick="set_cart_item()" class="btn btn-success pull-right btn_set_detail">Set Detail</button>
                            </div>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-responseive table-bordered">
                            <thead>
                                <tr>
                                    <!-- <th>Item Code</th> -->
                                    <th>Barcode</th>
                                    <th>Item Name</th>
                                    <th style="width: 100px;">Price</th>
                                    <th><?= $_POST['avg_sales'] ?> (Qty)</th>
                                    <th>Qty</th>
                                    <th>Target</th>
                                    <th style="width: 80px;">(%)</th>
                                    <th>Value</th>
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

        <div style="display:block;" id="containerSetDetail">
            <?php //$this->view('table_cart_item_detail') 
            ?>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                        <h4>Costing lain - lain</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Desc</th>
                                    <th style="width: 200px;">Costing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control input_other_desc">
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="calculateTotalCostingOther(this)" class="form-control input_other_cost">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control input_other_desc">
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="calculateTotalCostingOther(this)" class="form-control input_other_cost">
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>TOTAL</td>
                                    <td>
                                        <input type="text" id="total_costing_other" class="form-control" readonly value="0">
                                    </td>
                                </tr>
                            </tfoot>
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
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header"></div>
                    <div class="box-body">
                        <table class="table table-responsove table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Group</th>
                                </tr>
                                <?php $no = 1;
                                foreach ($group_customer->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->GroupName ?></td>
                                    </tr>
                                <?php } ?>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="display:block">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        <table class="table table-responseive table-bordered" id="table1">
                            <thead>
                                <tr>
                                    <th>Customer Code</th>
                                    <th>Group Name</th>
                                    <th>Customer Name</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyCustomer">
                                <?php foreach ($customer->result() as $data) { ?>
                                    <tr>
                                        <td class="CustomerCode_Customer">
                                            <?= $data->CardCode ?>
                                            <input type="hidden" class="input_group" value="<?= $data->GroupCode ?>">
                                            <input type="hidden" class="input_customer" value="<?= $data->CardCode ?>">
                                        </td>
                                        <td class="GroupName_Customer"><?= $data->GroupName ?></td>
                                        <td class="CustomerName_Customer"><?= $data->CustomerName ?></td>
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
$CardCode = array();
$GroupCode = array();

foreach ($customer->result() as $data) {
    array_push($CardCode, $data->CardCode);
    array_push($GroupCode, $data->GroupCode);
}


$customer_code = implode(",", $CardCode);
$group_code = implode("','", $GroupCode);
// var_dump($customer_code);
?>

<script>
    $(document).ready(function() {
        calculate_cost_ratio();
        // console.log('<?= strtolower(getActivityName($_POST['activity'])) ?>')
        if ('<?= strtolower(getActivityName($_POST['activity'])) ?>' == 'rafraction') {
            var inputs_desc = document.querySelectorAll(".input_other_desc")
            inputs_desc.forEach(function(e) {
                e.readOnly = true
            })
            var inputs_cost_other = document.querySelectorAll(".input_other_cost")
            inputs_cost_other.forEach(function(w) {
                w.readOnly = true
            })
        }
    });

    //function mengihitung total qty dan target sesuai itemcode
    function hitungEstimasi(input) {

        var total = 0;
        var item_code = input.getAttribute('data-item-code')

        //mencari element input dengan itemcode yang sesuai
        var inputs = document.querySelectorAll(`input[data-item-code="${item_code}"]`);

        //menjumlahkan semua input qty sesuai itemcode yang sesuai
        inputs.forEach(input => {
            const value = parseFloat(input.value); // Mengubah nilai menjadi tipe angka (float)
            if (!isNaN(value)) {
                total += value;
            }
        });

        //meletakan total qty estimation pada item code yang sesuai
        input_estimation = document.querySelector(`input[data-item-code-estimation="${item_code}"]`)
        input_estimation.value = total

        //mengambil price dengan itemcode yang sesuai
        var input_price = document.querySelector(`input[data-price-item-code="${item_code}"]`)
        var price = parseFloat(input_price.value.replace(/,/g, ''));

        //menentukan target value
        var input_target = document.querySelector(`input[data-target-item-code="${item_code}"]`)
        if (!isNaN(parseFloat(price * total))) {
            input_target.value = money(parseFloat(price * total))
        } else {
            input_target.value = 0
        }

        //menjumlahkan total target
        let total_target = 0
        var inputs_target = document.querySelectorAll(".input_target")
        inputs_target.forEach(input => {
            const val = parseFloat(input.value.replace(/,/g, ''))
            if (!isNaN(val)) {
                total_target += val
            }
        })

        const input_total_target = document.getElementById("total_target")
        input_total_target.value = money(total_target)


        //menentukan costing
        var input_value_item_code = document.querySelector(`input[data-value-item-code="${item_code}"]`)
        var value_promo = parseFloat(input_value_item_code.value.replace(/,/g, ''))
        var costing = parseFloat(input_estimation.value.replace(/,/g, '')) * value_promo
        var costing_item_code = document.querySelector(`input[data-costing-item-code="${item_code}"]`)
        costing_item_code.value = money(costing)

        //total costing
        let total_costing = 0
        var inputs_costing = document.querySelectorAll(".input_costing")
        inputs_costing.forEach(input => {
            const cost = parseFloat(input.value.replace(/,/g, ''))
            total_costing += cost
        })

        const input_total_costing = document.getElementById("total_costing")
        input_total_costing.value = money(total_costing)

        calculateAllTotalCosting();
        calculate_cost_ratio();
        // console.log(price);
        // console.log(total);
        // console.log(total_target);

    }


    function validationEstimasi(e) {
        var item_code = e.parentElement.parentElement.querySelector(".td_item_code").innerText
        var max_estimasi = e.parentElement.parentElement.querySelector(".max_estimasi").value
        var item_codes = document.querySelectorAll(".td_item_code")
        let total_val_estimation_this_item_code = 0;

        for (let i = 0; i < item_codes.length; i++) {
            var all_item_code = document.querySelectorAll(".td_item_code")[i].innerText
            if (all_item_code == item_code) {

                // console.log(i)
                var value_estimasi = document.querySelectorAll(".qty_estimasi_detail")[i].value
                total_val_estimation_this_item_code = parseFloat(total_val_estimation_this_item_code) + parseFloat(value_estimasi)
                // console.log(value_estimasi)
                // console.log(all_item_code)
            }
        }
        // console.log(total_val_estimation_this_item_code)
        // console.log(max_estimasi)

        if (total_val_estimation_this_item_code > max_estimasi) {
            Swal.fire('Maximal qty estimation : ' + max_estimasi)
            e.value = 0
        }
        // console.log(item_code)
        // console.log(item_codes)
    }

    function showModalItem(brand) {
        loadingShow();
        var td_barcode = document.querySelectorAll('.barcode_item')
        var barcode = []


        for (var i = 0; i < td_barcode.length; i++) {
            barcode.push(td_barcode[i].innerText)
        }

        // console.log(barcode)


        var avg_sales = '<?= $_POST['avg_sales'] ?>';
        var customer_code = "<?= $customer_code ?>";
        var start_date = '<?= $_POST['start_date'] ?>';
        $('#showModalItem').load('<?= base_url($_SESSION['page'] . '/showModalItemFromPenjualan') ?>', {
            brand,
            customer_code,
            start_date,
            avg_sales,
            barcode
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

        if (!isNaN(input_price) && input_price != 0) {
            promo = Math.round((promo_value / input_price) * 100);
            input_promo.value = !isNaN(promo) ? promo : 0;
        } else {
            input_promo.value = 0
        }

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
        // td_total_costing.innerText = !isNaN(total_costing) ? money(total_costing) : 0;
        calculateAllTotalCosting()
        calculate_cost_ratio();
    }

    function normalNumber(x) {
        return parseFloat(x.replace(/,/g, ''));
    }

    function money(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function calculateCosting(e) {

        // console.log(e)

        var totalCostingOther = document.getElementById("total_costing_other").value

        var row = e.parentElement
        var input_costing = document.querySelectorAll(".input_costing")
        var td_total_costing = document.getElementById("td_total_costing")
        var total_costing = 0
        for (i = 0; i < input_costing.length; i++) {
            if (!input_costing[i].value.replace(/,/g, '').isNaN) {
                total_costing += parseFloat(input_costing[i].value.replace(/,/g, ''))
            }
        }
        // console.log(total_costing)
        // var input_costing = e.querySelector()
        var input_total_costing = document.getElementById("total_costing")
        input_total_costing.value = money(total_costing)
        calculateAllTotalCosting()
        // td_total_costing.innerText = money(total_costing + parseFloat(totalCostingOther))
    }

    function calculate(e) {
        var row = e.parentElement.parentElement;
        var inputPrice = row.querySelector('input.input_price');
        inputPrice.value = inputPrice.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var inputQty = row.querySelector('input.input_qty');
        var inputTarget = row.querySelector('input.input_target');
        var inputPromo = row.querySelector('input.input_promo');

        var inputValPromo = row.querySelector('input.input_value_promo');

        if (!isNaN(inputPrice.value.replace(/,/g, '')) && inputPrice.value.replace(/,/g, '') != 0) {
            var percentss = (parseFloat(inputValPromo.value.replace(/,/g, '')) / parseFloat(inputPrice.value.replace(/,/g, ''))) * 100
            inputPromo.value = Math.round(percentss)
        } else {
            inputPromo.value = 0
        }


        var inputCosting = row.querySelector('input.input_costing');
        var costing = 0;
        costing = ((inputPromo.value / 100) * inputPrice.value.replace(/,/g, '')) * parseFloat(inputQty.value.replace(/,/g, ''));
        // inputCosting.value = !isNaN(parseFloat(costing)) ? Math.round(costing).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;

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
        // td_total_costing.innerText = !isNaN(parseFloat(total_costing)) ? total_costing.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
        calculateAllTotalCosting()
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


    function set_cart_item() {

        <?php
        // Include the PHP code here
        // PHP code
        $myArray = $customer_code;
        $myArrayJSON = json_encode($myArray);
        echo "var customer = " . $myArrayJSON . ";";

        $result_group = $group_customer->result();
        $array_group = array();

        foreach ($group_customer->result() as $data) {
            array_push($array_group, $data->GroupCode);
        }


        $json_group = json_encode($array_group);
        echo "var group_customer = " . $json_group . ";";

        ?>



        // console.log(customer)

        var avg_sales = "<?= $_POST['avg_sales'] ?>"
        var start_date = "<?= $_POST['start_date'] ?>"
        var end_date = "<?= $_POST['end_date'] ?>"
        var brand = "<?= $_POST['brand'] ?>"
        var no_proposal = "<?= $number ?>"
        var item_code = [];
        var item_qty = [];
        var input_item_code = document.querySelectorAll('input.itemCode_item');
        var input_qty = document.querySelectorAll('input.input_qty');
        for (var x = 0; x < input_item_code.length; x++) {
            item_code.push(input_item_code[x].value);
            item_qty.push(input_qty[x].value.replace(/,/g, ''));
        }
        // console.log(item_code);
        // console.log(item_qty);




        // return false

        if (item_code.length > 0) {


            var qty_inputs = document.querySelectorAll('.input_qty')
            // for (let i = 0; i < qty_inputs.length; i++) {
            //     if (qty_inputs[i].value === "" || qty_inputs[i].value === "0") {
            //         Swal.fire({
            //             icon: 'warning',
            //             title: 'Input sales estimation tidak boleh kosong!',
            //         })
            //         return false;
            //     }

            // }

            // var promo_inputs = document.querySelectorAll('.input_value_promo')
            // for (let i = 0; i < promo_inputs.length; i++) {
            //     if (promo_inputs[i].value === "" || promo_inputs[i].value === "0") {
            //         Swal.fire({
            //             icon: 'warning',
            //             title: 'Input value promo tidak boleh kosong!',
            //         })
            //         return false;
            //     }
            // }


            //cek budget
            var budget_saldo = '<?= (float)str_replace(',', '', $_POST['balance_budget']) ?>';
            var total_costing = $('#td_total_costing').text().replace(/,/g, '');

            // console.log(budget_saldo)
            // console.log(total_costing)

            if (parseFloat(total_costing) > parseFloat(budget_saldo)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Balance tidak cukup!',
                })
                return false;
            }





            Swal.fire({
                icon: 'question',
                title: 'Anda yakin lanjut ke set detail, \n Tabel product tidak bisa dirubah kembali',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                // denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    loadingShow();

                    $("#containerSetDetail").load('<?= base_url($_SESSION['page'] . '/set_cart_item') ?>', {
                        group_customer,
                        no_proposal,
                        item_code,
                        item_qty,
                        customer,
                        avg_sales,
                        start_date,
                        end_date,
                        brand,
                    });

                    //Swal.fire('Saved!', '', 'success')
                    // loadingShow();
                    // $.ajax({
                    //     type: "POST",
                    //     url: "<?= base_url($_SESSION['page']) . '/set_cart_item' ?>",
                    //     data: {
                    //         group_customer,
                    //         no_proposal,
                    //         item_code,
                    //         item_qty,
                    //         customer,
                    //         avg_sales,
                    //         start_date,
                    //         end_date,
                    //         brand,
                    //     },
                    //     dataType: "JSON",
                    //     success: function(response) {
                    //         // Handle the response from the server
                    //         //console.log(response.success);
                    //         if (response.success == true) {
                    //             $("#containerSetDetail").load('<?= base_url($_SESSION['page'] . '/get_cart_item') ?>', {
                    //                 customer
                    //             });

                    //             const inputs_price = document.querySelectorAll('.input_price'); // select all input elements of type "text"
                    //             for (let i = 0; i < inputs_price.length; i++) {
                    //                 inputs_price[i].readOnly = true; // set the readOnly property to true for each element

                    //             }

                    //             const inputs_avg = document.querySelectorAll('.input_avg_sales'); // select all input elements of type "text"
                    //             for (let i = 0; i < inputs_avg.length; i++) {
                    //                 inputs_avg[i].readOnly = true; // set the readOnly property to true for each element

                    //             }

                    //             const inputs = document.querySelectorAll('.input_qty'); // select all input elements of type "text"
                    //             for (let i = 0; i < inputs.length; i++) {
                    //                 inputs[i].readOnly = true; // set the readOnly property to true for each element

                    //             }
                    //             const promo_inputs = document.querySelectorAll('.input_value_promo'); // select all input elements of type "text"
                    //             for (let i = 0; i < promo_inputs.length; i++) {
                    //                 promo_inputs[i].readOnly = true; // set the readOnly property to true for each element

                    //             }
                    const btn_delete = document.querySelectorAll('.btn_delete_product'); // select all input elements of type "text"
                    for (let i = 0; i < btn_delete.length; i++) {
                        btn_delete[i].disabled = true; // set the disabled property to true for each element
                        btn_delete[i].style.display = 'none';
                    }

                    const btn_pilih_product = document.querySelectorAll('.btn_pilih_product'); // select all input elements of type "text"
                    for (let i = 0; i < btn_pilih_product.length; i++) {
                        btn_pilih_product[i].disabled = true; // set the disabled property to true for each element
                        btn_pilih_product[i].style.display = 'none';
                    }

                    const btn_set_detail = document.querySelectorAll('.btn_set_detail'); // select all input elements of type "text"
                    for (let i = 0; i < btn_set_detail.length; i++) {
                        btn_set_detail[i].disabled = true; // set the disabled property to true for each element
                        btn_set_detail[i].style.display = 'none';
                    }
                    loadingHide();
                    //         }
                    //     },
                    //     error: function(xhr, status, error) {
                    //         // Handle errors here
                    //         console.log("Error: " + error);
                    //     }
                    // });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Tentukan product terlebih dahulu',
            })
        }
    }

    function customer_item() {
        const no_proposal = []
        const customers = []
        const items = []
        const avg_sales = []
        const estimations = []
        const customer_items = []
        var input_customer = document.querySelectorAll('.customer_item')
        var input_item = document.querySelectorAll('.customer_item_code')
        var input_avg_sales = document.querySelectorAll('.qty_avg_sales')
        var input_estimasi = document.querySelectorAll('.qty_estimasi_detail')


        // validasi inputan tidak valid
        const input_qty_estimasi = document.querySelectorAll('input[name="qty_estimasi_detail"]');
        let input_estimation_valid = true
        try {
            input_qty_estimasi.forEach(function(classElement) {
                if (classElement.value.trim() === "" || classElement.value < 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Input estimasi tidak valid',
                    })
                    input_estimation_valid = false
                    throw new Error('Input estimasi tidak valid');
                }
            });
        } catch (error) {
            console.error(error.message);
        }

        if (!input_estimation_valid) {
            return false
        }

        for (var i = 0; i < input_customer.length; i++) {
            no_proposal.push("<?= $number ?>")
            customers.push(input_customer[i].value)
            items.push(input_item[i].value)
            estimations.push(input_estimasi[i].value)
            avg_sales.push(input_avg_sales[i].value)
        }

        customer_items.push(no_proposal, customers, items, estimations, avg_sales)
        var json_customer_items = JSON.stringify(customer_items)
        return json_customer_items
    }

    function validatation_item_estimations() {
        let validatation_item_estimation = true
        const inputEstimationMax = document.querySelectorAll('input[data-estimation]');
        const inputElements = document.querySelectorAll('input[data-cic]');
        const dataEstimataion = new Map();
        const dataValues = new Map();

        for (const inputEstimation of inputEstimationMax) {
            const keyMapEstimation = inputEstimation.dataset.estimation
            const valMapEstimation = Number(inputEstimation.value)
            dataEstimataion.set(keyMapEstimation, valMapEstimation)
        }

        // console.log(dataEstimataion)
        // Memproses setiap input dengan atribut data-id
        for (const input of inputElements) {
            const dataId = input.dataset.cic;
            const value = Number(input.value);

            // Menambahkan nilai ke dalam Map berdasarkan data-id
            if (dataValues.has(dataId)) {
                const existingValue = dataValues.get(dataId);
                dataValues.set(dataId, existingValue + value);
            } else {
                dataValues.set(dataId, value);
            }
        }

        // console.log(dataValues)

        // Menampilkan hasil penjumlahan untuk setiap data-id di console
        for (const [dataId, value] of dataValues) {
            console.log(`Data ID "${dataId}": ${value}`);
        }

        //dimatikan sementara
        //Membandingkan kedua map untuk validasi inputan estimasi sesuai
        // for (let [key, value] of dataEstimataion) {
        //     if (dataValues.has(key) && dataValues.get(key) === value) {
        //         console.log(`The value of key ${key} is the same in both maps`);
        //     } else {
        //         console.log(`The value of key ${key} is different in the two maps`);
        //         Swal.fire({
        //             icon: 'warning',
        //             title: `Product ${key} tidak sesuai, \n Max : ${value}, Terisi : ${dataValues.get(key)}`,
        //             // text: `Product ${key} tidak sesuai estimatimasi`,
        //         })
        //         validatation_item_estimation = false
        //         return false
        //     }
        // }

        return validatation_item_estimation

    }

    function calculateTotalCostingOther(e) {
        // console.log(e)


        var input_costing_other = document.querySelectorAll(".input_other_cost")
        var input_total_costing_other = document.getElementById("total_costing_other")

        var total_costing = 0
        var total_costing_1 = 0
        var total_costing_2 = 0

        for (var i = 0; i < input_costing_other.length; i++) {
            if (!isNaN(parseFloat(input_costing_other[i].value.replace(/,/g, '')))) {
                total_costing_2 += parseFloat(input_costing_other[i].value.replace(/,/g, ''))
            }
        }

        if (isNaN(total_costing_2)) {
            input_total_costing_other.value = 0;
        } else {
            input_total_costing_other.value = total_costing_2;
        }

        calculateAllTotalCosting()
    }

    function calculateAllTotalCosting() {
        var total_costing = 0

        var input_total_costing_1 = document.getElementById("total_costing")
        var input_total_costing_2 = document.getElementById("total_costing_other")

        total_costing = parseFloat(input_total_costing_1.value.replace(/,/g, '')) + parseFloat(input_total_costing_2.value.replace(/,/g, ''))

        var td_total_costing = document.getElementById("td_total_costing")
        td_total_costing.innerText = total_costing
    }

    function simpanProposal() {

        const other_desc = []
        const cost_other = []
        const no_doc = document.getElementById("no-doc").value
        const qty_estimation_inputs = document.querySelectorAll('.qty_estimasi_detail')

        var total_costing = 0
        var total_costing_1 = 0
        var total_costing_2 = 0

        if (!isNaN(parseFloat($('#total_costing').val().replace(/,/g, '')))) {
            total_costing_1 = parseFloat($('#total_costing').val().replace(/,/g, ''))
        }

        var input_desc_other = document.querySelectorAll(".input_other_desc")
        var input_costing_other = document.querySelectorAll(".input_other_cost")

        for (var i = 0; i < input_costing_other.length; i++) {
            if (!isNaN(parseFloat(input_costing_other[i].value.replace(/,/g, '')))) {
                total_costing_2 += parseFloat(input_costing_other[i].value.replace(/,/g, ''))
                other_desc.push(input_desc_other[i].value)
                cost_other.push(parseFloat(input_costing_other[i].value.replace(/,/g, '')))
            }
        }

        total_costing = total_costing_1 + total_costing_2
        // console.log(total_costing_1)
        // console.log(total_costing_2)
        // console.log(total_costing)

        // return false


        if (total_costing < 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Costing tidak boleh kosong',
            })
            return false
        }

        if (document.querySelectorAll(".table_detail_target").length < 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Set detail terlebih dahulu',
            })
            return false
        }

        var table_detail = document.getElementById("table_detail_target")
        var t_target = table_detail.querySelectorAll(".t_target")
        var t_qty_item = []
        var t_group = []
        var t_item_code = []
        var t_sales = []

        for (var i = 0; i < t_target.length; i++) {
            t_qty_item.push(table_detail.querySelectorAll(".t_target")[i].value)
            t_group.push(table_detail.querySelectorAll(".t_group")[i].value)
            t_item_code.push(table_detail.querySelectorAll(".t_item")[i].value)
            t_sales.push(table_detail.querySelectorAll(".t_qty")[i].value)
        }


        // console.log(t_qty_item)
        // console.log(t_group)
        // console.log(t_item_code)
        // console.log(t_sales)
        // console.log(table_detail)




        // console.log(qty_estimation_inputs.length)
        // return false






        const valid_item_estimation = validatation_item_estimations()
        // console.log(validatation_item_estimations())

        if (!valid_item_estimation) {
            // console.log("tidak sesuai estimasi")
            return false
        }

        const json_customer_items = customer_item()

        if (!json_customer_items) {
            // console.log("stop")
            return false
        }

        // console.log(json_customer_items)
        // return false

        // var input_group = document.querySelectorAll('input.input_group');
        // var input_customer = document.querySelectorAll('input.input_customer');
        // var group_code = [];
        // var customer_code = [];
        // for (var y = 0; y < input_customer.length; y++) {
        //     group_code.push(input_group[y].value);
        //     customer_code.push(input_customer[y].value);
        // }

        var brand = '<?= $_POST['brand'] ?>';
        var activity = '<?= $_POST['activity'] ?>';
        var start_date = '<?= $_POST['start_date'] ?>';
        var end_date = '<?= $_POST['end_date'] ?>';
        var budget_code = '<?= $_POST['budget_code'] ?>';
        var budget_code_activity = '<?= $_POST['budget_code_activity'] ?>';
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
        // var total_costing = $('#total_costing').val().replace(/,/g, '');
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


        var customer_code = <?php echo json_encode(explode(",", $customer_code)); ?>;
        // var customer_code = "<?php echo $customer_code; ?>";
        // console.log(customer_code);
        // return false;
        // var td_customer_code = document.querySelectorAll('td.CustomerCode_Customer');
        // for (var c = 0; c < td_customer_code.length; c++) {
        //     customer_code.push(td_customer_code[c].innerText.replace(/\s/g, ""));
        // }

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
        } else if (customer_code.length < 1) {
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


        //cek no ref must be unix
        if (document.getElementById("no-doc").value == '') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'No document tidak boleh kosong',
            })
            return false;
        }


        //cek no ref already exists
        var no_ref_is_exists = false;
        var data_no_doc = {
            no_doc: no_doc.replace(/[\s\t]/g, "")
        };
        // Melakukan permintaan POST dengan jQuery
        // $.post("<?= base_url($_SESSION['page']) . '/cekNoDoc' ?>", data_no_doc).done(function(response) {
        //     if (response.success == true) {
        //         no_ref_is_exists = true;
        //     }
        // });

        no_ref_is_exists = $.ajax({
            url: "<?= base_url($_SESSION['page']) . '/cekNoDoc' ?>",
            type: "POST",
            data: data_no_doc,
            async: false,
            success: function(response) {
                // Menangani respons dari server
                //console.log(response);
                if (response.success == true) {
                    no_ref_is_exists = true;
                }
            }
        }).done(function(response) {
            return response.success
        });

        // console.log(JSON.parse(no_ref_is_exists.responseText).success)

        if (JSON.parse(no_ref_is_exists.responseText).success == true) {
            Swal.fire({
                icon: 'error',
                title: 'No document \n' + no_doc.replace(/[\s\t]/g, "") + '\n sudah ada',
            })
            return false;
        }

        // console.log('lanjut')
        // return false;
        //confirmation before save




        Swal.fire({
            icon: 'question',
            title: 'Anda yakin untuk simpan proposal?\n Total Costing : ' + total_costing,
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            // denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                loadingShow();
                $.post("<?= base_url($_SESSION['page']) . '/simpanProposalRev' ?>", {
                    t_qty_item,
                    t_group,
                    t_item_code,
                    t_sales,
                    brand,
                    activity,
                    start_date,
                    end_date,
                    budget_code,
                    budget_code_activity,
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
                    customer_code: JSON.stringify(customer_code),
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
                    customer_items: json_customer_items,
                    no_doc: no_doc.replace(/[\s\t]/g, ""),
                    other_desc,
                    other_cost: cost_other,
                }, function(result) {
                    if (result.success == true) {
                        loadingHide()
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

            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })




    }
</script>