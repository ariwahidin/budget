<?php
// var_dump($operating_header->result());
// var_dump($operating->result());

?>

<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col col-md-6">
                <h4>Breakdown Activity <span><button onclick="showModalActivity()" class="btn btn-primary">Pilih Activity</button></span></h4>
            </div>
            <div class="col col-md-6">
                <button onclick="simpan()" class="btn btn-success pull-right">Save</button>
            </div>
        </div>
    </section>
    <section class="content" id="main_content">
        <div class="row">
            <div class="col-md-3">
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
                            <tr style="display:none">
                                <td>Target (<?= $operating->row()->Valas ?>)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalPrincipalTargetValas) ?></td>
                            </tr>
                            <tr>
                                <td>Principal Target (IDR)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalPrincipalTargetIDR) ?></td>
                            </tr>
                            <tr>
                                <?php
                                $target_prencentage = 0;
                                // $target_prencentage = ($operating_header->row()->TotalTargetAnp / $operating_header->row()->TotalPrincipalTargetIDR) * 100;
                                ?>
                                <td>Principal A&P (IDR)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalTargetAnp) ?></td>
                            </tr>
                            <tr>
                                <td>PK Target (IDR)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalPKTargetIDR) ?></td>
                            </tr>
                            <tr>
                                <td>PK A&P (IDR)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalPKAnpIDR) ?></td>
                            </tr>
                            <tr>
                                <td>Operating</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalOperating) ?></td>
                            </tr>
                            <tr>
                                <td>IMS Target</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalImsTarget) ?></td>
                            </tr>
                            <tr>
                                <td>IMS Budget</td>
                                <td>&nbsp;:&nbsp; <?= number_format($operating_header->row()->TotalImsBudget) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8" id="container_form_activity">

            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
                foreach ($operating->result() as $op) {
                ?>
                    <input type="hidden" class="month" value="<?= $op->Month ?>">
                <?php
                }
                ?>

            </div>
        </div>
    </section>
</div>

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
    }

    function addFormActivity(e) {
        var budget_code = e.dataset.budget_code;
        var activity = e.dataset.activity_code;
        var row = e.parentElement.parentElement
        // console.log(row)
        // return false;
        $('#container_form_activity').append($('<div>').load("<?= base_url($_SESSION['page'] . '/showFormActivity') ?>", {
            budget_code,
            activity
        }))
        row.remove()
        // $('#modal_pilih_activity').modal('hide');
    }

    function deleteForm(e) {
        var row = e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
        // console.log(row);
        row.remove();
        // calculateTotalUsedAllActivityPerMonth()
        // calculatePercent()
    }

    function hitungValuePerActivity(e) {
        const totalOperating = "<?= $operating_header->row()->TotalOperating ?>";
        const this_val = e.value;
        var this_component = e.parentElement.parentElement.parentElement;
        var editText_inputValuePerActivity = this_component.querySelector(".inputValuePerActivity");
        const operatingActivityValue = (this_val / 100) * totalOperating
        // console.log(this_component)
        editText_inputValuePerActivity.value = operatingActivityValue
    }

    function simpan() {
        var elems = document.querySelectorAll('.inputPrecentagePeractivity');
        var total = 0;
        const budget_code = "<?= $budget_code ?>";
        const budget_code_activity = [];
        const activity = [];
        const month = [];
        const list_budget_activity = [];

        const budget_activity_index = [];
        const budget_activity = [];
        var input_month = document.querySelectorAll(".month");
        var act = document.querySelectorAll(".act");
        var input_budget_activity = document.querySelectorAll(".inputValuePerActivity");

        for (var i = 0; i < elems.length; i++) {
            total += parseInt(elems[i].value == "" ? 0 : elems[i].value);
        }

        if (total > 100) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Operating tidak cukup'
            })
            return false;
        }

        if (total < 100) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Activity belum sesuai operating'
            })
            return false;
        }

        if (total == 100) {





            for (var b = 0; b < input_budget_activity.length; b++) {
                list_budget_activity.push(input_budget_activity[b].value);
            }

            for (var m = 0; m < input_month.length; m++) {
                month.push(input_month[m].value);

                // for(var y = 0 ; y < budget_activity_index.length ; y++){
                //     budget_activity.push
                // }
            }

            for (var x = 0; x < act.length; x++) {
                activity.push(act[x].value);
                budget_code_activity.push(budget_code + "/" + act[x].value);
            }

            console.log(activity);
            console.log(budget_code_activity);
            console.log(month);
            console.log(list_budget_activity);



            Swal.fire({
                icon: "question",
                title: 'Apa anda yakin untuk simpan?',
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    loadingShow()
                    $.ajax({
                        url: "<?= base_url($_SESSION['page'] . '/simpanOperatingActivity') ?>",
                        type: "POST",
                        data: {
                            brand_code: "<?= $brand ?>",
                            activity: activity,
                            budget_code: "<?= $budget_code ?>",
                            budget_code_activity: budget_code_activity,
                            month: month,
                            budget_activity: list_budget_activity,
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.success == true) {
                                loadingHide()
                                window.location.href = "<?= base_url($_SESSION['page'] . '/showOperating') ?>";
                            } else {
                                loadingHide()
                                //alert("Gagal simpan data");
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning',
                                    text: 'Failed to save data',
                                })
                            }
                        }
                    });
                }
            })


        }
    }
</script>