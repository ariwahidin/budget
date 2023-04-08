<?php
// var_dump($_SESSION);
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Create Proposal</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-info">
                    <form id="formCreate">
                        <div class="box-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td>Brand : </td>
                                    <td>
                                        <select class="form-control select2" name="brand" id="brand">
                                            <option value="">--Pilih--</option>
                                            <?php foreach ($brand->result() as $b) { ?>
                                                <option value="<?= $b->BrandCode ?>"><?= $b->BrandName ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activity : </td>
                                    <td>
                                        <select class="form-control select2" name="activity" id="activity">
                                            <option value="">--Pilih--</option>
                                            <?php foreach ($activity->result() as $ac) { ?>
                                                <option value="<?= $ac->id ?>"><?= $ac->ActivityName ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Periode from :</td>
                                    <td>
                                        <input name="start_date" type="date" id="end_date" class="form-control col-md-6">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Periode to :</td>
                                    <td>
                                        <input name="end_date" type="date" class="form-control col-md-6" id="end_date" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Group Customer :</td>
                                    <td>
                                        <select class="form-control select2" name="group" id="group">
                                            <option value="">--Pilih--</option>
                                            <?php foreach ($group->result() as $grp) { ?>
                                                <option value="<?= $grp->GroupCode ?>"><?= $grp->GroupName ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>AVG Sales :</td>
                                    <td>
                                        <input name="avg_sales" type="text" class="form-control" id="avg_sales" value="Non Sales" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Claim to :</td>
                                    <td>
                                        <select name="claim_to" id="" class="form-control select2">
                                            <option value="">--Pilih--</option>
                                            <option value="pandurasa">Pandurasa</option>
                                            <option value="principal">Principal</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                    <div class="box-footer">
                        <button id="" onclick="create()" class="btn btn-primary pull-right">
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
        // $('#next').on('click', function() {
        //     var brand_code = $('#brand').val();
        //     var activity = $('#activity').val();
        //     var start_date = $('#start_date').val();
        //     var end_date = $('#end_date').val();
        //     var group = $('#group').val();

        //     $.ajax({
        //         url : '<?= base_url($_SESSION['page'] . '/createProposal2') ?>',
        //         type : 'POST',
        //         data : {
        //             brand_code, activity, start_date, end_date, group, 
        //         },
        //         dataType : 'JSON',
        //         success: function(response){

        //         }
        //     });
        // })
    })

    function create() {
        var brand = $('#brand').val();
        var activity = $('#activity').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var group = $('#group').val();
        if (brand == '' || activity == '' || start_date == '' || end_date == '' || group == '') {
            //alert('Semua harus diisi');
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Input cannot be empty',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        if ($('#avg_sales').val() == '') {
            //alert('Semua harus diisi');
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Input cannot be empty',
                // footer: '<a href="">Why do I have this issue?</a>'
            })
            return false;
        }

        var form = document.getElementById("formCreate");
        var formData = new FormData(form);
        $.ajax({
            url: '<?= base_url($_SESSION['page'] . '/checkData') ?>',
            processData: false,
            contentType: false,
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            success: function(response) {
                if (response.budget_code == false) {
                    //alert('Budget tidak ditemukan');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Budget is not found',
                        // footer: '<a href="">Why do I have this issue?</a>'
                    })
                }

                // return false;

                if (response.success == true) {
                    var input_actual_budget = document.createElement('input');
                    var input_allocated_budget = document.createElement('input');
                    var input_operating_budget = document.createElement('input');
                    var input_operating_budget_activity = document.createElement('input');
                    var input_operating_budget_activity_percent = document.createElement('input');
                    var input_budget_code_activty = document.createElement('input');

                    input_actual_budget.name = 'ytd_actual_budget';
                    input_allocated_budget.name = 'ytd_allocated_budget';
                    input_operating_budget.name = 'ytd_operating_budget';
                    input_operating_budget_activity.name = 'ytd_operating_budget_activity';
                    input_operating_budget_activity_percent.name = 'ytd_operating_budget_activity_percent';
                    input_budget_code_activty.name = 'budget_code_activity';

                    input_actual_budget.type = 'hidden';
                    input_allocated_budget.type = 'hidden';
                    input_operating_budget.type = 'hidden';
                    input_operating_budget_activity.type = 'hidden';
                    input_operating_budget_activity_percent.type = 'hidden';
                    input_budget_code_activty.type = 'hidden';

                    input_actual_budget.value = response.ytd_actual_budget;
                    input_allocated_budget.value = response.ytd_allocated_budget;
                    input_operating_budget.value = response.ytd_operating_budget;
                    input_operating_budget_activity.value = response.ytd_operating_budget_activity;
                    input_operating_budget_activity_percent.value = response.ytd_operating_budget_activity_percent;
                    input_budget_code_activty.value = response.budget_code_activity;

                    form.action = "<?= base_url($_SESSION['page'] . '/createProposal2') ?>";
                    form.method = "POST";
                    form.appendChild(input_actual_budget);
                    form.appendChild(input_allocated_budget);
                    form.appendChild(input_operating_budget);
                    form.appendChild(input_operating_budget_activity);
                    form.appendChild(input_operating_budget_activity_percent);
                    form.appendChild(input_budget_code_activty);
                    form.submit();
                }

            }
        });
    }
</script>