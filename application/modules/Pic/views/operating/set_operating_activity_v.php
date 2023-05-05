<?php
// var_dump($brand);
// var_dump($budget_code);
// var_dump($operating_header->result());
// var_dump($operating->row()->Valas);
// die;
?>
<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h4>Breakdown Activity</h4>

    </section>
    <section class="content" id="main_content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <table class="">
                            <tr>
                                <td>Brand</td>
                                <td>&nbsp;:&nbsp; <?= getBrandName($brand) ?></td>
                            </tr>
                            <tr>
                                <td>Start Periode</td>
                                <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($operating_header->row()->StartPeriode)) ?></td>
                            </tr>
                            <tr>
                                <td>End Periode</td>
                                <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($operating_header->row()->EndPeriode)) ?></td>
                            </tr>
                            <tr>
                                <td>Target (<?= $operating->row()->Valas ?>)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalPrincipalTargetValas) ?></td>
                            </tr>
                            <tr>
                                <td>Target (IDR)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalPrincipalTargetIDR) ?></td>
                            </tr>
                            <tr>
                                <?php
                                $target_prencentage = 0;
                                $target_prencentage = ($operating_header->row()->TotalTargetAnp / $operating_header->row()->TotalPrincipalTargetIDR) * 100;
                                ?>
                                <td>A&P (IDR) (<?= round($target_prencentage) ?>%)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalTargetAnp) ?></td>
                            </tr>
                            <tr>
                                <?php
                                $operating_percent = 0;
                                $operating_percent = ($operating_header->row()->TotalOperating / $operating_header->row()->TotalTargetAnp) * 100;
                                ?>
                                <td>Operating (<?= round($operating_percent) ?>%)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalOperating) ?></td>
                            </tr>
                        </table>
                        <button onclick="showModalActivity()" class="btn btn-primary pull-right">Pilih Activity</button>
                        <!-- <button class="btn btn-primary pull-right" style="margin-right: 5px;">Edit</button> -->
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php foreach ($operating->result() as $data) { ?>
                                        <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A&P (IDR)</td>
                                    <?php foreach ($operating->result() as $op) { ?>
                                        <td><?= number_format($op->Target) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>Operating</td>
                                    <?php foreach ($operating->result() as $op) { ?>
                                        <td class="td_operating"><?= number_format($op->OperatingBudget) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>Allocation Budget</td>
                                    <?php foreach ($operating->result() as $op) { ?>
                                        <td class="td_totalValueAllActivityPerMonth"></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>Percent</td>
                                    <?php foreach ($operating->result() as $op) { ?>
                                        <td class="td_percent"></td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <button onclick="simpan()" class="btn btn-primary pull-right">Simpan</button>
            </div>
        </div>
    </section>
</div>
<!-- <div class="modal fade" id="modal_pilih_activity222" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="table_activity">
                    <thead>
                        <tr>
                            <th>Activity Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activity->result() as $ac) { ?>
                            <tr>
                                <td><?= $ac->ActivityName ?></td>
                                <td>
                                    <button onClick="addFormActivity(this)" data-activity_code="<?= $ac->id ?>" data-budget_code="<?= $budget_code ?>" class="btn btn-primary">Select</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btn_set_promo" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
</div> -->
<div id="muncul_modal_activity"></div>

<?php $this->view('footer') ?>
<script>
    $(document).ready(function() {
        $('.table_operating').DataTable();
        $('#table_activity').DataTable();
    })

    function showModalActivity() {
        var input_activity = document.querySelectorAll('input.act');
        var budget_code = '<?= $budget_code ?>';
        var activity = [];
        for (var i = 0; i < input_activity.length; i++) {
            activity.push(input_activity[i].value);
        }
        $('#muncul_modal_activity').load("<?= base_url($_SESSION['page'] . '/showModalActivity') ?>", {
            activity,
            budget_code
        });
        // console.log(input_activity);
        // $('#modal_pilih_activity').modal('show');
    }

    function addFormActivity(e) {
        var budget_code = e.dataset.budget_code;
        var activity = e.dataset.activity_code;
        $('#main_content').append($('<div>').load("<?= base_url($_SESSION['page'] . '/showFormActivity') ?>", {
            budget_code,
            activity
        }))
        $('#modal_pilih_activity').modal('hide');
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function calculateFromPercent(elem) {
        var percent = elem.value;
        percent = (parseFloat(percent) / 100);
        var operating = 0;
        var operating_source = elem.parentElement.querySelector(".input_operating").value;
        var input_operating = elem.parentElement.querySelector(".input_operating_manual");
        operating = Math.round(parseFloat(operating_source) * percent);
        input_operating.value = !isNaN(operating) ? operating.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '';
        // console.log(operating);
    }

    function formatNumber(num) {
        var value = num.value.replace(/,/g, '');
        value = parseFloat(value);
        return num.value = isNaN(value) ? '' : value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function calculateTotalUsedAllActivityPerMonth() {
        var td_used = document.querySelectorAll('td.td_totalValueAllActivityPerMonth'); //12
        var rows = document.querySelectorAll('div.row_activity');
        for (var i = 0; i < td_used.length; i++) {
            var used = 0;
            for (var x = 0; x < rows.length; x++) {
                var money = document.querySelectorAll('input.operating_' + i)[x].value.replace(/,/g, '');
                used += parseFloat(money);
            }

            console.log(used);

            td_used[i].innerText = !isNaN(used) ? used.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;

        }
    }

    function calculatePercent() {
        var operating = document.querySelectorAll('td.td_operating');
        var used = document.querySelectorAll('td.td_totalValueAllActivityPerMonth');
        var td_percent = document.querySelectorAll('td.td_percent');
        var persen = 0;
        for (var i = 0; i < td_percent.length; i++) {
            persen = (parseFloat(used[i].innerText.replace(/,/g, '')) / parseFloat(operating[i].innerText.replace(/,/g, ''))) * 100;
            if (!isNaN(persen)) {
                td_percent[i].innerText = Math.round(persen) + '%';
            } else if (parseFloat(used[i].innerText.replace(/,/g, '')) == parseFloat(operating[i].innerText.replace(/,/g, ''))) {
                td_percent[i].innerText = '100%';
            }
        }
    }

    function calculate(e) {
        // console.log(e.parentElement.querySelector(".input_operating_manual"));
        e = e.parentElement.querySelector(".input_operating_manual");
        var col = e.parentElement;
        var precentagePerActivity = 0;
        var inputPrecentagePerActivity = col.parentElement.parentElement.parentElement.parentElement.parentElement;
        inputPrecentagePerActivity = inputPrecentagePerActivity.querySelector('input.inputPrecentagePeractivity');
        inputPrecentagePermonth = col.parentElement.querySelectorAll('input.input_percentage_permonth');
        var inputValuePerActivity = col.parentElement.parentElement.parentElement.parentElement.parentElement.querySelector('input.inputValuePerActivity');
        var operating_value = parseFloat(e.value.replace(/,/g, ''));
        var input_percentage_permonth = col.querySelector('input.input_percentage_permonth');
        var input_operating_parent = col.querySelector('input.input_operating');
        var operating_parent = parseFloat(input_operating_parent.value);
        var percentage_permonth = 0;
        var inputValuePerActivityYear = col.parentElement.parentElement.parentElement.parentElement.parentElement.querySelectorAll('input.input_operating_manual');
        // console.log(inputValuePerActivityYear);
        percentage_permonth = (operating_value / operating_parent) * 100;
        input_percentage_permonth.value = !isNaN(percentage_permonth) ? percentage_permonth.toFixed(2) + '%' : 0 + '%';
        var totalPrecentagePerActivity = 0;
        var valuePerActivity = 0;
        for (var i = 0; i < inputPrecentagePermonth.length; i++) {
            if (inputPrecentagePermonth[i].value != '') {
                totalPrecentagePerActivity += parseFloat(inputPrecentagePermonth[i].value);
            }
            if (inputValuePerActivityYear[i].value != '') {
                valuePerActivity += parseFloat(inputValuePerActivityYear[i].value.replace(/,/g, ''));
            }
        }
        totalPrecentagePerActivity = totalPrecentagePerActivity / inputPrecentagePermonth.length;
        inputPrecentagePerActivity.value = totalPrecentagePerActivity.toFixed(2);
        inputValuePerActivity.value = valuePerActivity.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function deleteForm(e) {
        var row = e.parentElement.parentElement.parentElement.parentElement;
        // console.log(row);
        row.remove();
        calculateTotalUsedAllActivityPerMonth()
        calculatePercent()
    }

    function simpan() {
        var budget_code = "<?= $budget_code ?>";
        var brand_code = "<?= $brand ?>";
        var input_precentage = document.querySelectorAll('input.input_precentage');
        var input_activity = document.querySelectorAll('input.input_activity');
        var input_budget_code = document.querySelectorAll('input.input_budget_code');
        var input_month = document.querySelectorAll('input.input_month');
        var input_operating_activity = document.querySelectorAll('input.input_operating_activity');
        var input_budget_activity = document.querySelectorAll('input.input_operating_manual');
        var precentage = [];
        var activity = [];
        var budget_code_activity = [];
        var month = [];
        var operating_activity = [];
        var budget_activity = [];

        for (var i = 0; i < input_activity.length; i++) {
            precentage.push(input_precentage[i].value);
            activity.push(input_activity[i].value);
            budget_code_activity.push(input_budget_code[i].value);
            month.push(input_month[i].value);
            operating_activity.push(input_operating_activity[i].value);
            budget_activity.push(parseFloat(input_budget_activity[i].value.replace(/,/g, '')));
        }

        // Awal Validasi
        // var pct = document.querySelectorAll('input.pct');
        // var p = 0;
        // for (var x = 0; x < pct.length; x++) {
        //     p += parseFloat(pct[x].value);
        // }

        // if (p > 100) {
        //     alert("presentase tidak boleh lebih dari 100%");
        //     return false
        // } else if (p < 100) {
        //     alert("presentase tidak boleh kurang dari 100%");
        //     return false
        // } else if (isNaN(p)) {
        //     alert("Isian tidak valid");
        //     return false
        // }

        var input_act = document.querySelectorAll('input.act');
        var act = [];
        for (var a = 0; a < input_act.length; a++) {
            act.push(input_act[a].value);
        }

        const duplicates = act.filter((item, index) => index !== act.indexOf(item));
        if (duplicates.length > 0) {
            //alert("Activity tidak boleh sama");
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Activity names must not be the same',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }


        var td_percent = document.querySelectorAll('td.td_percent');
        for (var i = 0; i < td_percent.length; i++) {
            if (td_percent[i].innerText == '') {
                //alert("Semua Harus Diisi");
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'All fileds are mandatory',
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
                return false;
            } else if (td_percent[i].innerText.replace(/%/gi, '') > 100) {
                //alert("Setting Activity Melebihi Operating");
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Activity exceeds operating limit',
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
                return false;
            } else if (td_percent[i].innerText.replace(/%/gi, '') < 100) {
                //alert("Setting Activity Kurang Dari Operating");
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Activity bellow operating limit',
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
                return false;
            }
        }

        var input_percentage = document.querySelectorAll('input.input_precentage');
        for (var i = 0; i < input_percentage.length; i++) {
            if (input_percentage[i].value == '') {
                //alert('Inputan tidak boleh kosong');
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Input cannot be empty',
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
                return false;
            }
        }

        $.ajax({
            url: "<?= base_url($_SESSION['page'] . '/simpanOperatingActivity') ?>",
            type: "POST",
            data: {
                brand_code,
                activity,
                budget_code,
                budget_code_activity,
                month,
                budget_activity,
            },
            dataType: "JSON",
            success: function(response) {
                if (response.success == true) {
                    window.location.href = "<?= base_url($_SESSION['page'] . '/showOperating') ?>";
                } else {
                    //alert("Gagal simpan data");
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Failed to save data',
                        // footer: '<a href="">Why do I have this issue?</a>'
                    })
                }
            }
        });
    }
</script>