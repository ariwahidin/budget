<?php
// var_dump($activity->result());
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
        if(brand == '' || activity == '' || start_date == '' || end_date == '' || group == ''){
            alert('Semua harus diisi');
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
            success: function(response){
                if(response.budget_code == false){
                    alert('Budget tidak ditemukan');
                }

                if(response.success == true){
                    var input = document.createElement('input');
                    var input_budget_code = document.createElement('input');
                    input_budget_code.type = 'hidden';
                    input_budget_code.name = 'budget_code';
                    input_budget_code.value = response.budget_code;
                    input.type = 'hidden';
                    input.name = 'operating';
                    input.value = response.operating;
                    form.action = "<?=base_url($_SESSION['page']. '/createProposal2')?>";
                    form.method = "POST";
                    form.appendChild(input);
                    form.appendChild(input_budget_code);
                    form.submit();
                }

            } 
        });
    }
</script>