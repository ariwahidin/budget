<?php
// var_dump($_POST);
// var_dump($ims);
// var_dump($ims_omset);
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Create Operating</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form id="budget">
                    <input type="hidden" name="valas" class="valas" value="<?= $_POST['valas'] ?>">
                    <input type="hidden" name="exchange_rate" class="exchange_rate" value="<?= $_POST['exchange_rate'] ?>">
                    <input type="hidden" name="budget_type" class="budget_type" value="<?= $_POST['budget_type'] ?>">
                    <div class="box">
                        <div class="box-header">
                            <table>
                                <tr>
                                    <td>Brand</td>
                                    <td>&nbsp;:&nbsp; <?= getBrandName($brand) ?>
                                        <input type="hidden" name="brand_code" class="brand_code" value="<?= $brand ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Start Month</td>
                                    <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($start_month)) ?>
                                        <input type="hidden" name="start_month" class="start_month" value="<?= $start_month ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>End Month</td>
                                    <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($end_month)) ?>
                                        <input type="hidden" name="end_month" class="end_month" value="<?= $end_month ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Budget Type</td>
                                    <td>&nbsp;:&nbsp; <?= ucfirst($_POST['budget_type']) ?></td>
                                </tr>
                                <tr style="display:none">
                                    <td>Exchange Rate</td>
                                    <td>&nbsp;:&nbsp; <b><?= number_format($_POST['exchange_rate']) ?></b></td>
                                </tr>
                                <tr style="display:none">
                                    <td>Target <?= $_POST['valas'] ?></td>
                                    <td>&nbsp;:&nbsp; <b id="total_principal_aud"></b></td>
                                </tr>
                                <tr>
                                    <td>Target IDR</td>
                                    <td>&nbsp;:&nbsp; <b id="total_principal_idr"></b></td>
                                </tr>
                                <tr>
                                    <td>A&P</td>
                                    <td>&nbsp;:&nbsp; <b id="total_target"></b></td>
                                </tr>
                                <tr>
                                    <td>Operating (<?= $_POST['percent_operating'] ?>%) </td>
                                    <td>&nbsp;:&nbsp; <b id="total_operating"></b></td>
                                </tr>
                                <tr>
                                    <td>IMS</td>
                                    <td>&nbsp;:&nbsp; <b><?= $_POST['set_ims'] == 'Y' ? 'Yes' : 'No' ?></b></td>
                                </tr>
                                <tr>
                                    <td>IMS Target</td>
                                    <td>&nbsp;:&nbsp; <b id="total_ims_target"></b></td>
                                </tr>
                                <tr>
                                    <td>IMS Budget</td>
                                    <td>&nbsp;:&nbsp; <b id="total_ims_budget"></b></td>
                                </tr>
                            </table>
                        </div>
                        <div class="box-body">
                            <table class="table table-responsive table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th style="display:none">Target (<?= $_POST['valas'] ?>)</th>
                                        <th>Target (IDR)</th>
                                        <th style="display:none">A&P (<?= $_POST['valas'] ?>)</th>
                                        <th>A&P (IDR)</th>
                                        <th>Operating (IDR) (<?= $_POST['percent_operating'] ?>%)</th>
                                        <?php if ($_POST['set_ims'] = 'Y') { ?>
                                            <th>IMS Target</th>
                                            <th>IMS Budget</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($periode as $month) { ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <?= date('M - Y', strtotime($month)) ?>
                                                <input type="hidden" name="month[]" class="input_month" value="<?= $month ?>">
                                            </td>
                                            <td style="display:none">
                                                <input type="text" name="principal_target_valas[]" onpaste="calculating(this)" onkeypress="javascript:return isNumber(event)" onkeyup="formatNumber(this); calculating(this)" class="form-control input_principal_target_aud target_valas" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="principal_target_idr[]" onkeypress="javascript:return isNumber(event)" onkeyup="formatNumber(this); calculateTargetValas(this)" class="form-control input_principal_target_idr">
                                            </td>
                                            <td style="display:none">
                                                <input type="text" name="anp_principal_valas[]" onkeypress="javascript:return isNumber(event)" onkeyup="formatNumber(this); calculating(this)" class="form-control input_anp_valas" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="anp_principal_idr[]" onkeypress="javascript:return isNumber(event)" onkeyup="formatNumber(this);calculatingOperating(this);calculatingAnpValas(this)" class="form-control input_target">
                                            </td>
                                            <td>
                                                <input type="text" name="anp_operating[]" onkeypress="javascript:return isNumber(event)" onkeyup="formatNumber(this)" class="form-control input_operating" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="input_ims_target[]" onkeypress="javascript:return isNumber(event)" onkeyup="formatNumber(this)" class="form-control input_ims_target" value="0" <?= $_POST['set_ims'] == 'N' ? 'readonly' : ''; ?>>
                                            </td>
                                            <td>
                                                <input type="text" name="input_ims[]" onkeypress="javascript:return isNumber(event)" onkeyup="formatNumber(this)" class="form-control input_ims" value="0" <?= $_POST['set_ims'] == 'N' ? 'readonly' : ''; ?>>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <button type="button" onclick="simpan()" class="btn btn-primary pull-right">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php $this->view('footer'); ?>
<script>
    $(document).ready(function() {

    });

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
        calculate();
        return num.value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function calculateTargetValas(el) {
        var valueValas = "<?= $_POST['exchange_rate'] ?>"
        var valueTarget = el.value.replace(/,/g, '')
        var row = el.parentElement.parentElement
        var inputTargetValas = row.querySelector('.target_valas')
        var targetValas = parseFloat(valueTarget / valueValas)
        inputTargetValas.value = targetValas
    }

    function calculatingOperating(el) {
        var persenOperating = "<?= $_POST['percent_operating'] ?>"
        var row = el.parentElement.parentElement
        var inputOperating = row.querySelector('.input_operating')
        var anpValue = el.value.replace(/,/g, '')
        var operatingValue = parseFloat((persenOperating / 100) * anpValue)
        inputOperating.value = operatingValue
    }

    function calculatingAnpValas(el) {
        var valueValas = "<?= $_POST['exchange_rate'] ?>"
        var row = el.parentElement.parentElement
        var inputAnpValas = row.querySelector('.input_anp_valas')
        var anpValue = el.value.replace(/,/g, '')
        var anpValas = parseFloat(anpValue / valueValas)
        inputAnpValas.value = anpValas
    }

    function calculating(elem) {
        var value = parseFloat(elem.value.replace(/,/g, ''));
        var exchange_rate = parseFloat('<?= $_POST['exchange_rate'] ?>');
        var percent_anp = parseFloat('<?= $_POST['percent_anp'] ?>') / 100;
        var percent_operating = parseFloat('<?= $_POST['percent_operating'] ?>') / 100;
        var rows = elem.parentElement.parentElement;
        var target_valas = rows.querySelector('input.input_principal_target_aud').value;
        var anp_valas = rows.querySelector('input.input_anp_valas').value;
        target_valas = parseFloat(target_valas.replace(/,/g, ''));
        anp_valas = parseFloat(anp_valas.replace(/,/g, ''));
        var idr = rows.querySelector('input.input_principal_target_idr');
        var idr_value = 0;
        var input_anp_idr = rows.querySelector('input.input_target');
        var anp_idr_value = 0;

        anp_idr_value = Math.round((value * exchange_rate) * percent_anp);
        input_anp_idr.value = !isNaN(anp_idr_value) ? anp_idr_value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '';

        idr_value = (target_valas * exchange_rate);
        idr.value = !isNaN(idr_value) ? idr_value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '';

        var anp_valas_value = 0;
        anp_valas_value = parseFloat(value) * percent_anp;
        rows.querySelector('input.input_anp_valas').value = Math.round(anp_valas_value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        var operating = 0;
        operating = Math.round(((value * exchange_rate) * percent_anp) * percent_operating);
        rows.querySelector('input.input_operating').value = operating.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        calculate();
    }



    function calculate() {
        var input_principal_aud = document.querySelectorAll('input.input_principal_target_aud');
        var input_principal_idr = document.querySelectorAll('input.input_principal_target_idr');
        var input_target = document.querySelectorAll('input.input_target');
        var input_operating = document.querySelectorAll('input.input_operating');
        var input_ims_target = document.querySelectorAll('input.input_ims_target');
        var input_ims_budget = document.querySelectorAll('input.input_ims');

        var b_total_principal_aud = document.getElementById('total_principal_aud');
        var b_total_principal_idr = document.getElementById('total_principal_idr');
        var b_total_target = document.getElementById('total_target');
        var b_total_operating = document.getElementById('total_operating');
        var b_total_ims_target = document.getElementById('total_ims_target');
        var b_total_ims_budget = document.getElementById('total_ims_budget');

        var total_aud = 0;
        var total_idr = 0;
        var total_target = 0;
        var total_operating = 0;
        var total_ims_target = 0;
        var total_ims_budget = 0;
        for (var i = 0; i < input_target.length; i++) {

            if (input_principal_aud[i].value != '') {
                total_aud += parseFloat(input_principal_aud[i].value.replace(/,/g, ''));
            }

            if (input_principal_idr[i].value != '') {
                total_idr += parseFloat(input_principal_idr[i].value.replace(/,/g, ''));
            }

            if (input_target[i].value != '') {
                total_target += parseFloat(input_target[i].value.replace(/,/g, ''));
            }

            if (input_operating[i].value != '') {
                total_operating += parseFloat(input_operating[i].value.replace(/,/g, ''));
            }

            if (input_ims_target[i].value != '') {
                total_ims_target += parseFloat(input_ims_target[i].value.replace(/,/g, ''));
            }

            if (input_ims_budget[i].value != '') {
                total_ims_budget += parseFloat(input_ims_budget[i].value.replace(/,/g, ''));
            }
        }

        b_total_principal_aud.innerText = total_aud.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        b_total_principal_idr.innerText = total_idr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        b_total_target.innerText = total_target.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        b_total_operating.innerText = total_operating.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        b_total_ims_target.innerText = total_ims_target.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        b_total_ims_budget.innerText = total_ims_budget.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function simpan() {
        var input_target = document.querySelectorAll('input.input_target');
        var input_operating = document.querySelectorAll('input.input_operating');

        var target = [];
        var operating = [];
        var month = [];
        var input = $('input');

        for (var i = 0; i < input.length; i++) {
            if (input[i].value == '') {
                //alert('Semua harus diisi');
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'All fields must be to fill',
                })
                return false;
            }
        }

        var brand_code = '<?= $brand ?>';
        var valas = '<?= $_POST['valas'] ?>';
        var budget_type = '<?= $_POST['budget_type'] ?>';
        var exchange_rate = '<?= $_POST['exchange_rate'] ?>';
        var input_month = document.querySelectorAll('input.input_month');
        var input_principal_target_valas = document.querySelectorAll('input.input_principal_target_aud');
        var input_principal_target_idr = document.querySelectorAll('input.input_principal_target_idr');
        var input_principal_anp_valas = document.querySelectorAll('input.input_anp_valas');
        var input_principal_anp_idr = document.querySelectorAll('input.input_target');
        var input_operating = document.querySelectorAll('input.input_operating');
        var input_ims_target = document.querySelectorAll('input.input_ims_target');
        var input_ims_budget = document.querySelectorAll('input.input_ims');

        var month = [];
        var principal_target_valas = [];
        var principal_target_idr = [];
        var principal_anp_valas = [];
        var principal_anp_idr = [];
        var operating = [];
        var ims_target = [];
        var ims_budget = [];

        var set_ims = '<?= $_POST['set_ims'] ?>';
        var ims_percent = '<?= $_POST['percentage_ims'] == '' ? 0 : $_POST['percentage_ims'] ?>';

        for (var i = 0; i < input_month.length; i++) {
            month.push(input_month[i].value);
            principal_target_valas.push(parseFloat(input_principal_target_valas[i].value.replace(/,/g, '')));
            principal_target_idr.push(parseFloat(input_principal_target_idr[i].value.replace(/,/g, '')));
            principal_anp_valas.push(parseFloat(input_principal_anp_valas[i].value.replace(/,/g, '')));
            principal_anp_idr.push(parseFloat(input_principal_anp_idr[i].value.replace(/,/g, '')));
            operating.push(parseFloat(input_operating[i].value.replace(/,/g, '')));
            ims_target.push(parseFloat(input_ims_target[i].value.replace(/,/g, '')));
            ims_budget.push(parseFloat(input_ims_budget[i].value.replace(/,/g, '')));
        }


        $.ajax({
            url: "<?= base_url($_SESSION['page'] . '/simpanOperating') ?>",
            type: "POST",
            // data: $('#budget').serialize(),
            data: {
                set_ims,
                ims_percent,
                budget_type,
                brand_code,
                valas,
                exchange_rate,
                month: month,
                principal_target_valas: principal_target_valas,
                principal_target_idr: principal_target_idr,
                anp_principal_valas: principal_anp_valas,
                anp_principal_idr: principal_anp_idr,
                anp_operating: operating,
                ims_target: ims_target,
                ims_budget: ims_budget,
            },
            dataType: "json",
            success: function(response) {
                if (response.success == true) {
                    window.location.href = "<?= base_url($_SESSION['page'] . '/setOperatingActivity/') ?>" + response.budget_code;
                } else {
                    //alert('gagal simpan Data')
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