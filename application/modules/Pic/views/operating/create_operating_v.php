<!-- <?php var_dump($_SESSION) ?> -->
<?php $this->view('header'); ?>
<style>
    .use_ims {
        display: none;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Create New Budget</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                        <form id="formCreateOperating">
                            <div class="box-body">
                                <table class="table table-responsive">
                                    <tr>
                                        <td><label for="">Brand:</label></td>
                                        <td>
                                            <select class="form-control select2" name="brand" id="brand" required>
                                                <option value="">--Pilih--</option>
                                                <?php foreach ($brand->result() as $data) { ?>
                                                    <option value="<?= $data->BrandCode ?>"><?= $data->BrandName ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="start">Start month:</label></td>
                                        <td>
                                            <input type="month" class="form-control" id="start_month" name="start_month" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="start">End month:</label></td>
                                        <td>
                                            <input type="month" class="form-control" id="end_month" name="end_month" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="start">Valuta Asing:</label></td>
                                        <td>
                                            <select class="form-control select2" name="valas" id="valas" required>
                                                <option value="">--Pilih--</option>
                                                <option value="USD">USD</option>
                                                <option value="AUD">AUD</option>
                                                <option value="CHF">CHF</option>
                                                <option value="EUR">EUR</option>
                                                <option value="GBP">GBP</option>
                                                <option value="IDR">IDR</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="start">Exchange Rate:</label></td>
                                        <td>
                                            <input type="number" onkeypress="javascript:return isNumber(event)" min="0" class="form-control" id="exchange_rate" name="exchange_rate" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="start">A&P (%):</label></td>
                                        <td>
                                            <input type="number" onkeypress="javascript:return isNumber(event)" min="0" class="form-control" name="percent_anp">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="start">Operating (%):</label></td>
                                        <td>
                                            <input type="number" onkeypress="javascript:return isNumber(event)" min="0" class="form-control" name="percent_operating">
                                        </td>
                                    </tr>
                                    <tr style="display:none;">
                                        <td><label for="">Budget Type:</label></td>
                                        <td>
                                            <select class="form-control select2" name="budget_type" id="valas" required>
                                                <option value="">--Pilih--</option>
                                                <option value="pandurasa">Pandurasa</option>
                                                <option value="principal" selected>Principal</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr style="display:none;">
                                        <td><label for="">Set IMS:</label></td>
                                        <td>
                                            <select onchange="setIms()" class="form-control select2" name="set_ims" id="set_ims" required>
                                                <option value="">--Pilih--</option>
                                                <option value="Y">Yes</option>
                                                <option value="N" selected>No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="use_ims">
                                        <td><label for="start">Percentage IMS (%):</label></td>
                                        <td>
                                            <input type="number" min="0" max="100" class="form-control" id="" name="percentage_ims" value="0">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                        <button type="" onclick="createBudget()" class="btn btn-primary pull-right">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->view('footer'); ?>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })

    function setIms() {
        var set_ims = document.getElementById('set_ims').value;
        var tr_month_ims = document.querySelectorAll('tr.use_ims');
        if (set_ims == 'Y') {
            for (var i = 0; i < tr_month_ims.length; i++) {
                tr_month_ims[i].style.display = 'revert';
            }
        } else {
            for (var i = 0; i < tr_month_ims.length; i++) {
                tr_month_ims[i].style.display = 'none';
            }
        }
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function createBudget() {

        var all_input = document.querySelectorAll('input');
        var all_select = document.querySelectorAll('select');

        for (var s = 0; s < all_select.length; s++) {
            if (all_select[s].value == '') {
                // alert("Semua Wajib Diisi");
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Semua wajib diisi',
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
                return false;
            }
        }
        for (var i = 0; i < all_input.length; i++) {
            if (all_input[s].value == '') {
                //alert("Semua Wajib Diisi");
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Semua wajib diisi',
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
                return false;
            }
        }

        var formData = new FormData(document.getElementById("formCreateOperating"));

        var babi = $.ajax({
            url: '<?= base_url($_SESSION['page'] . '/check_budget_already') ?>',
            processData: false,
            contentType: false,
            async: false,
            type: 'POST',
            data: formData,
            dataType: 'JSON',
        });

        if (babi.responseJSON.budget == 'budget_already_exists') {
            //alert('Budget Sudah Ada');
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Budget sudah ada',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if (babi.responseJSON.budget == 'harus_setahun') {
            //alert('Periode Budget Harus 1 Tahun');
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Periode budget harus 1 tahun',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if (babi.responseJSON.budget == 'siap') {
            var form = document.getElementById("formCreateOperating");
            form.method = "POST";
            form.action = "<?= base_url($_SESSION['page'] . '/show_form_create_budget') ?>";
            form.submit();
        }


    }
</script>