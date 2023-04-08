<?php
// var_dump($brand);
// var_dump($budget_code);
// var_dump($activity->result());
?>
<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h4>Set Operating Activity <b><?=getBrandName($brand)?></b></h4>

    </section>
    <section class="content" id="main_content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <button onclick="showModalActivity()" class="btn btn-primary pull-right">Pilih Activity</button>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php foreach ($operating->result() as $data) { ?>
                                        <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php foreach ($operating->result() as $op) { ?>
                                        <td><?= number_format($op->OperatingBudget) ?></td>
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
<div class="modal fade" id="modal_pilih_activity" role="dialog">
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
</div>
<?php $this->view('footer') ?>
<script>
    $(document).ready(function() {
        $('.table_operating').DataTable();
        $('#table_activity').DataTable();
    })

    function showModalActivity() {
        $('#modal_pilih_activity').modal('show');
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

    function calculate(e) {
        e.value = parseFloat(e.value);
        var precentage = parseFloat(e.value) / 100;
        var row = e.parentElement.parentElement.parentElement.parentElement;
        var input_precentage = row.querySelectorAll('input.input_precentage');
        var input_operating = row.querySelectorAll('input.input_operating');
        var input_operating_activity = row.querySelectorAll('input.input_operating_activity');
        var span_operating_activity = row.querySelectorAll('span.span_operating_activity');
        var operating_activity = 0;
        for (var i = 0; i < input_operating_activity.length; i++) {
            operating_activty = input_operating[i].value * precentage;
            input_precentage[i].value = e.value;
            input_operating_activity[i].value = !isNaN(operating_activty) ? operating_activty : 0;
            span_operating_activity[i].innerHTML = !isNaN(operating_activty) ? operating_activty.toLocaleString() : 0;
        }
    }

    function deleteForm(e) {
        var row = e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
        row.remove();
    }

    function simpan() {
        var budget_code = "<?= $budget_code ?>";
        var brand_code = "<?= $brand ?>";
        var input_precentage = document.querySelectorAll('input.input_precentage');
        var input_activity = document.querySelectorAll('input.input_activity');
        var input_budget_code = document.querySelectorAll('input.input_budget_code');
        var input_month = document.querySelectorAll('input.input_month');
        var input_operating_activity = document.querySelectorAll('input.input_operating_activity');
        var precentage = [];
        var activity = [];
        var budget_code_activity = [];
        var month = [];
        var operating_activity = [];
        for (var i = 0; i < input_activity.length; i++) {
            precentage.push(input_precentage[i].value);
            activity.push(input_activity[i].value);
            budget_code_activity.push(input_budget_code[i].value);
            month.push(input_month[i].value);
            operating_activity.push(input_operating_activity[i].value);
        }

        // Awal Validasi
        var pct = document.querySelectorAll('input.pct');
        var p = 0;
        for (var x = 0; x < pct.length; x++) {
            p += parseFloat(pct[x].value);
        }

        if (p > 100) {
            alert("presentase tidak boleh lebih dari 100%");
            return false
        } else if (p < 100) {
            alert("presentase tidak boleh kurang dari 100%");
            return false
        } else if (isNaN(p)) {
            alert("Isian tidak valid");
            return false
        }

        var input_act = document.querySelectorAll('input.act');
        var act = [];
        for(var a = 0 ; a < input_act.length ; a++){
            act.push(input_act[a].value);
        }

        const duplicates = act.filter((item, index) => index !== act.indexOf(item));
        if(duplicates.length > 0){
            alert("Activity tidak boleh sama");
            return false;
        }
        // Akhir validasi


        $.ajax({
            url: "<?= base_url($_SESSION['page'] . '/simpanOperatingActivity') ?>",
            type: "POST",
            data: {
                brand_code,
                precentage,
                budget_code,
                activity,
                budget_code_activity,
                month,
                operating_activity
            },
            dataType: "JSON",
            success: function(response){
                if(response.success == true){
                    window.location.href = "<?= base_url($_SESSION['page'] . '/showOperating') ?>";
                }else{
                    alert("Gagal simpan data");
                }
            }
        });
    }
</script>