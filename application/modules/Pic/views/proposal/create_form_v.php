<?php
// var_dump($_SESSION['user_code']);

// var_dump($customer->result());
?>
<?php
// var_dump($_SESSION);
?>
<?php $this->view('header'); ?>
<style>
    .table_header tr td {
        padding: 0 !important;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
                <h4>Create Proposal</h4>
            </div>
            <div class="col-md-6">
                <button id="" onclick="create()" class="btn btn-primary pull-right">Next</button>
                <button class="btn btn-primary pull-right" id="btn_cari_customer" onclick="cariCustomer()" style="margin-right:5px">Cari Customer</button>
            </div>
        </div>
    </section>
    <section class="content">
        <form id="formCreate">
            <input type="hidden" id="json_customer" name="json_customer">
            <div class="row">
                <div class="col-md-5">
                    <div class="box box-info">
                        <div class="box-body">
                            <table class="table table-responsive table_header">
                                <tr>
                                    <td style="display: none;">No. Doc</td>
                                    <td style="display: none;">
                                        <div class="input-group">
                                            <input id="input-no-doc" name="no_doc" type="text" value="<?= $noref ?>" class="form-control" readonly>
                                            <div class="input-group-btn">
                                                <button type="button" onclick="checkNoDoc()" class="btn btn-primary">Check</button>
                                            </div>
                                            <!-- /btn-group -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Brand</td>
                                    <td>
                                        <select onchange="resetBudget()" class="form-control select2" name="brand" id="brand">
                                            <option value="">--Pilih--</option>
                                            <?php foreach ($brand->result() as $b) { ?>
                                                <option value="<?= $b->BrandCode ?>"><?= $b->BrandName ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Group Customer</td>
                                    <td>
                                        <select onchange="resetTableCustomer(this)" name="group_customer_" id="group" class="form-control select2" multiple required>
                                            <option value="">--Pilih Group--</option>
                                            <?php foreach ($group->result() as $member_group) { ?>
                                                <option value="<?= $member_group->GroupCode ?>"><?= $member_group->GroupName ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Periode from</td>
                                    <td>
                                        <input onchange="resetBudget()" name="start_date" type="date" id="start_date" class="form-control col-md-6" required min="<?= date('Y-m-d') ?>" max="2025-12-31">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Periode to</td>
                                    <td>
                                        <input onchange="resetBudget()" name="end_date" type="date" class="form-control col-md-6" id="end_date" value="" required min="<?= date('Y-m-d') ?>" max="2025-12-31">
                                    </td>
                                </tr>

                                <tr>
                                    <td>Activity</td>
                                    <td>
                                        <select onchange="resetBudget(); changeActivity()" class="form-control" name="activity" id="activity" required>
                                            <option value="">--Pilih--</option>
                                            <?php foreach ($activity->result() as $ac) { ?>
                                                <option data-is_sales="<?= $ac->sales ?>" value="<?= $ac->id ?>"><?= $ac->ActivityName ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="is_sales" id="is_sales">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sales</td>
                                    <td>
                                        <select onchange="changeAVG()" name="avg_sales" id="avg_sales" class="form-control" required>
                                            <option value="">--Pilih--</option>
                                            <option value="Last 3 Month">Last 3 Month</option>
                                            <!-- <option value="none">None</option> -->
                                            <!-- <input name="avg_sales" type="text" class="form-control" id="avg_sales" value="Last 3 Month" readonly> -->
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Budget</td>
                                    <td>
                                        <select onchange="getBudget();" name="budget_source" id="budget_source" class="form-control" required>
                                            <option value="">--Pilih--</option>
                                            <option value="anp">A&P</option>
                                            <option value="on_top">On Top</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Operating</td>
                                    <td>
                                        <input type="text" class="form-control" value="0" id="operatingBudget" readonly required>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td>Unbooked</td> -->
                                    <td>Used</td>
                                    <td><input type="text" class="form-control" name="allocated_budget" id="allocated_budget" readonly required></td>
                                </tr>
                                <tr>
                                    <td>Balance</td>
                                    <td>
                                        <input type="text" class="form-control" name="balance_budget" value="0" id="balance_budget" readonly required>
                                        <input type="hidden" id="balance_operating" require>
                                        <input type="hidden" name="budget_code" id="budget_code" required>
                                        <input type="hidden" name="budget_code_activity" id="budget_code_activity" required>
                                        <input type="hidden" name="total_budget_activity" id="total_budget_activity" required>
                                        <input type="hidden" name="total_operating" id="total_operating" required>
                                    </td>
                                </tr>

                                <tr style="display: none;">
                                    <td>Booked</td>
                                    <td><input type="text" class="form-control" name="budget_booked" id="budget_booked" readonly required></td>
                                </tr>
                                <tr style="display:none">
                                    <!-- <td>YTD Operating Budget - Target</td> -->
                                    <td>Operating Activity</td>
                                    <td><input type="text" class="form-control" name="budget_activity" id="budget_activity" readonly required></td>
                                </tr>
                                <tr style="display: none;">
                                    <td>YTD Operating Budget - Purchase</td>
                                    <td><input type="text" class="form-control" name="budget_actual" id="budget_actual" readonly required></td>
                                </tr>
                                <tr style="display:none">&nbsp;
                                    <td>IMS</td>
                                    <td>
                                        <input name="ims_value" id="ims_value" type="text" class="form-control" readonly required>
                                    </td>
                                </tr>
                                <tr id="use_ims" style="display:none;">
                                    <td></td>
                                    <td><input onchange="usingIMS();" name="ims" id="ims" type="checkbox" value="Y"> Gunakan IMS</td>
                                </tr>
                                <tr>
                                    <td class="col-md-4">Claim to</td>
                                    <td>
                                        <select name="claim_to" id="claim_to" class="form-control" required>
                                            <option value="">--Pilih--</option>
                                            <option value="pandurasa">Pandurasa</option>
                                            <option value="principal">Principal</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden">
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="box">
                        <div class="box-header">
                            <!-- <button class="btn btn-primary pull-right" id="btn_cari_customer" onclick="cariCustomer()">Cari Customer</button> -->
                        </div>
                        <div class="box-body">
                            <table class="table table-responsive table-bordered">
                                <thead>
                                    <tr>
                                        <th>Code Customer</th>
                                        <th>Group Customer</th>
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
        </form>
    </section>
</div>
<div id="showModalCustomer"></div>
<?php $this->view('footer'); ?>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })

    function noDocExists() {
        var noDoc = document.getElementById("input-no-doc").value
        var result = true;

        if (noDoc == '') {
            Swal.fire({
                icon: 'error',
                title: 'No doc kosong!',
            })
        } else {
            var ajaxNoDoc = $.ajax({
                url: '<?= base_url($_SESSION['page'] . '/cekNoDoc') ?>',
                type: 'POST',
                data: {
                    no_doc: noDoc
                },
                async: false,
                dataType: 'JSON',
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'error',
                            title: 'No doc ' + noDoc + ' sudah ada, tidak bisa digunakan',
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'No doc ' + noDoc + ' bisa digunakan',
                        })
                    }
                }
            });

            if (ajaxNoDoc.responseJSON.success == true) {
                result = true
            } else {
                result = false
            }
        }
        return result
    }

    function checkNoDoc() {
        noDocExists()
    }

    function changeAVG() {
        var avg = document.getElementById('avg_sales');
        var button_cari_customer = document.getElementById('btn_cari_customer');
        var tbodyCustomer = document.getElementById('tbodyCustomer');
        var input_activity = document.getElementById('activity');
        if (avg.value == 'none') {
            button_cari_customer.style.display = 'none';
            tbodyCustomer.innerHTML = '';
        } else {
            button_cari_customer.style.display = 'revert';
        }
    }

    function usingIMS() {
        var checkbox = document.getElementById('ims');
        var balance_operating = document.getElementById('balance_operating').value;
        var balance_ims = document.getElementById('ims_value').value;
        var input_balance = document.getElementById('balance_budget');
        if (checkbox.checked) {
            input_balance.value = balance_ims;
        } else {
            input_balance.value = balance_operating;
        }
    }

    function changeActivity() {
        var is_sales_element = document.getElementById('activity');
        var is_sales = is_sales_element.options[is_sales_element.selectedIndex].getAttribute('data-is_sales');
        var btn_cari_customer = document.getElementById('btn_cari_customer');
        var tbody_customer = document.getElementById('tbodyCustomer');
        if (is_sales == 'N') {
            btn_cari_customer.style.display = 'none';
            tbody_customer.innerHTML = '';
        } else {
            btn_cari_customer.style.display = 'revert';
        }
    }

    function resetIms() {
        var checkbox = document.getElementById('ims');
        if (checkbox.checked) {
            checkbox.checked = false;
        }
        var tr_ims = document.getElementById('use_ims').style.display = 'none';
    }


    function resetBudget() {
        var budget_source = document.getElementById('budget_source').value = '';
        var input_balance_budget = document.getElementById('balance_budget').value = '';
        var input_allocated_budget = document.getElementById('allocated_budget').value = '';
        var input_budget_booked = document.getElementById('budget_booked').value = '';
        var input_budget_activity = document.getElementById('budget_activity').value = '';
        var input_budget_actual = document.getElementById('budget_actual').value = '';
        var input_budget_code = document.getElementById('budget_code').value = '';
        var input_budget_code_activity = document.getElementById('budget_code_activity').value = '';
        var input_total_budget_activity = document.getElementById('total_budget_activity').value = '';
        var input_total_operating = document.getElementById('total_operating').value = '';
        var input_value_ims = document.getElementById('ims_value').value = '';
        document.getElementById('operatingBudget').value = '';
        var checkbox = document.getElementById('ims');
        if (checkbox.checked) {
            checkbox.checked = false;
        }
        var tr_ims = document.getElementById('use_ims').style.display = 'none';
    }

    function money(x) {
        return Math.round(x).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function normalNumber(x) {
        return parseFloat(x.replace(/,/g, ''));
    }

    function getBudget() {
        var budget_source = $('#budget_source').val();
        var brand = $('#brand').val();
        var activity = $('#activity').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var input_balance_budget = document.getElementById('balance_budget');
        var input_budget_booked = document.getElementById('budget_booked');
        var input_allocated_budget = document.getElementById('allocated_budget');
        var input_budget_activity = document.getElementById('budget_activity');
        var input_budget_actual = document.getElementById('budget_actual');
        var input_budget_code = document.getElementById('budget_code');
        var input_budget_code_activity = document.getElementById('budget_code_activity');
        var input_total_budget_activity = document.getElementById('total_budget_activity');
        var input_total_operating = document.getElementById('total_operating');
        var input_ims_value = document.getElementById('ims_value');
        var tr_use_ims = document.getElementById('use_ims');
        var input_balance_operating = document.getElementById('balance_operating');

        var inputOperatingBudget = document.getElementById('operatingBudget');

        $.ajax({
            url: '<?= base_url($_SESSION['page'] . '/get_budget') ?>',
            type: 'POST',
            data: {
                budget_source,
                brand,
                activity,
                start_date,
                end_date,
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.budget == 'not_set') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Budget Tidak Tersedia',
                    })
                    resetBudget()
                    return false;
                }

                if (response.budget_on_top == 'not_set') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Budget On Top Tidak Tersedia',
                    })
                    resetBudget()
                    return false;
                }

                console.log(response)

                input_balance_budget.value = money(response.balance);
                input_balance_operating.value = money(response.balance);
                input_allocated_budget.value = money(response.budget_used);
                input_budget_booked.value = money(response.budget_booked);
                input_budget_actual.value = money(response.actual_budget);
                input_budget_activity.value = money(response.budget_activity);
                input_budget_code.value = response.budget_code;
                input_budget_code_activity.value = response.budget_code_activity;
                input_total_budget_activity.value = money(response.total_budget_activity);
                input_total_operating.value = money(response.total_operating);
                input_ims_value.value = money(response.ims_value);

                inputOperatingBudget.value = money(response.operatingBudget);
                // console.log(response.balance);
                if (response.balance < 1000000) {
                    tr_use_ims.style.display = 'revert';
                } else if (budget_source == 'on_top') {
                    resetIms()
                }
            }
        })
    }

    function deleteRowCustomer(e) {
        e.parentElement.parentElement.remove();
    }

    function resetTableCustomer(input) {
        var group_selected = $(input).val()
        var tbodyCustomer = document.getElementById('tbodyCustomer')
        var trGroupCode = tbodyCustomer.querySelectorAll('tr[data-tr-group-code]')

        // ini untuk menentukan table customer sesuai sama group yang dipilih, jika di table customer tidak mengandung group yang dipilih maka barisnya akan dihapus
        if (group_selected.length > 0) {
            if (trGroupCode.length > 0) {
                trGroupCode.forEach(function(tr) {
                    var trValue = tr.getAttribute('data-tr-group-code')
                    if (!group_selected.includes(trValue)) {
                        tr.remove()
                    }
                })
            }
        } else {
            document.getElementById('tbodyCustomer').innerHTML = '';
        }
    }

    function cariCustomer() {

        var input_customer = document.querySelectorAll('input.input_customer');
        var customer = [];
        for (var i = 0; i < input_customer.length; i++) {
            customer.push(input_customer[i].value);
        }
        var group = $('#group').val();
        if (group == '') {
            //alert("Group customer belum dipilih");
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Group customer belum dipilih',
            })
            return false;
        } else {
            loadingShow();
            $('#showModalCustomer').load('<?= base_url($_SESSION['page'] . '/showModalCustomerFromSales') ?>', {
                group,
                customer
            })
        }

    }

    function create() {
        var brand = $('#brand').val();
        var activity = $('#activity').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var group = $('#group').val();
        var input_balance_budget = document.getElementById('balance_budget');

        if (brand == '' || activity == '' || start_date == '' || end_date == '' || group == '') {
            // alert('Semua harus diisi');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Semua wajib diisi',
            })
            return false;
        }

        if ($('#avg_sales').val() == '') {
            // alert('Semua harus diisi');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Semua wajib diisi',
            })
            return false;
        }

        var form = document.getElementById("formCreate");
        var input_customer = document.querySelectorAll('input.input_customer');
        var input_group = document.querySelectorAll('input.input_group');

        if (input_balance_budget.value <= 0 && document.getElementById('ims').checked == false) {
            // alert("Balance tidak mencukupi");
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Budget tidak cukup',
            })
            return false;
        }

        if (input_balance_budget.value <= 0 && document.getElementById('ims').value <= 0) {
            // alert("Balance tidak mencukupi");
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Budget tidak cukup',
            })
            return false;
        }

        var is_sales_element = document.getElementById('activity');
        var is_sales = is_sales_element.options[is_sales_element.selectedIndex].getAttribute('data-is_sales');
        var avg_sales = document.getElementById('avg_sales').value;
        document.getElementById('is_sales').value = is_sales;

        if (is_sales == 'N' && avg_sales != 'none') {
            // alert('Activity tidak sesuai dengan Avg Salesnya');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Activity tidak sesuai dengan Avg Salesnya',
            })
            return false;
        }

        if (is_sales == 'Y' && avg_sales == 'none') {
            // alert('Activity tidak sesuai dengan Avg Salesnya');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Activity tidak sesuai dengan Avg Salesnya',
            })
            return false;
        }

        if (is_sales == 'Y' && input_customer.length < 1) {
            // alert("Customer belum dipilih");
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Customer belum dipilih',
            })
            return false;
        }

        var budget_source = $('#budget_source').val();
        if (budget_source == "") {
            // alert("Budget belum ditentukan");
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Budget belum ditentukan',
            })
            resetIms();
            return false;
        }

        if (document.getElementById('claim_to').value == '') {
            // alert('Claim to belum diisi');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Claim belum diisi',
            })
            return false;
        }

        if (noDocExists() == true) {
            return false;
        }

        // console.log(form);

        Swal.fire({
            icon: 'warning',
            title: 'Anda yakin akan lanjut? \n Data tidak dapat dirubah kembali',
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Lanjukan',
            cancelButtonText: 'Check Kembali',
            // denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */




            if (result.isConfirmed) {

                var input_customer = document.querySelectorAll('input.input_customer')
                var customer_code = []
                input_customer.forEach(input => {
                    customer_code.push(input.value)
                })

                var json_customer = JSON.stringify(customer_code)
                var input_jsonCustomer = document.getElementById("json_customer");
                input_jsonCustomer.value = json_customer

                form.action = "<?= base_url($_SESSION['page'] . '/show_form_proposal_from_sales') ?>";
                form.method = "POST";
                form.submit();
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })

    }
</script>