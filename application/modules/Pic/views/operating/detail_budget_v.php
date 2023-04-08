<?php
// var_dump($brand_code);
// var_dump($budget_code);
// var_dump($budget_detail_header->result());
// var_dump($budget_detail->result());
// var_dump($activity->result());
// die;
// var_dump($_SESSION['page']);
?>
<?php $this->view('header') ?>
<style>
    .modal-dialog {
        width: 100%;
        /* height: 100%; */
        /* margin: 0; */
        /* padding: 0; */
    }

    .modal-content {
        height: auto;
        min-height: 100%;
        /* border-radius: 0; */
    }
</style>
<section class="content-wrapper">

    <section class="content-header">
        <h1>Budget Detail</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <table>
                            <tr>
                                <td>Brand</td>
                                <td>&nbsp;:&nbsp; <?= getBrandName($budget_detail->row()->BrandCode) ?></td>
                            </tr>
                            <tr>
                                <td>Start Periode</td>
                                <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($budget_detail->result()[0]->Month)) ?></td>
                            </tr>
                            <tr>
                                <td>End Periode</td>
                                <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($budget_detail->result()[11]->Month)) ?></td>
                            </tr>

                            <tr>
                                <td>Principal Target</td>
                                <td>&nbsp;:&nbsp; <?= number_format($budget_detail_header->row()->TotalPrincipalTargetIDR) ?></td>
                            </tr>
                            <tr>
                                <?php
                                $target_anp = 0;
                                $target_anp = ($budget_detail_header->row()->TotalTargetAnp / $budget_detail_header->row()->TotalPrincipalTargetIDR);
                                $target_anp_percent = $target_anp * 100;
                                ?>
                                <td>A&P Target (<?= round($target_anp_percent) ?>%)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($budget_detail_header->row()->TotalTargetAnp) ?></td>
                            </tr>
                            <tr>
                                <?php
                                $operating = 0;
                                $operating = ($budget_detail_header->row()->TotalOperating / $budget_detail_header->row()->TotalTargetAnp);
                                $operating_percent = $operating * 100;
                                ?>
                                <td>Operating Budget (<?= round($operating_percent) ?>%)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($budget_detail_header->row()->TotalOperating); ?></td>
                            </tr>
                            <tr>
                                <td>YTD Actual Purchase</td>
                                <?php
                                $actual_purchase = getActualPurchase($budget_detail->row()->BrandCode, $budget_detail_header->row()->StartPeriode, $budget_detail_header->row()->EndPeriode);
                                ?>
                                <td>&nbsp;:&nbsp; <?= number_format($actual_purchase); ?></td>
                            </tr>
                            <tr>
                                <?php
                                $total_actual_anp = 0;
                                $total_actual_anp = $actual_purchase * $target_anp;
                                ?>
                                <td>Actual A&P (<?= round($target_anp_percent) ?>%)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($total_actual_anp) ?></td>
                            </tr>
                            <tr>
                                <td>IMS</td>
                                <td>&nbsp;:&nbsp; <?= $is_ims ?></td>
                            </tr>
                            <tr>
                                <td>YTD IMS (<?= $ims_percent ?>%)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($ims_value) ?></td>
                            </tr>


                        </table>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Principal Target</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format($data->PrincipalTargetIDR) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>A&P Target</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format($data->TargetAnp) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>Operating Budget</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format($data->OperatingBudget) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>Actual Purchase</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format(getActualPurchasePerMonth($data->BrandCode, $data->Month)) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>Actual A&P</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format(getActualPurchasePerMonth($data->BrandCode, $data->Month) * $target_anp) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>Actual IMS</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format(getActualIMSPermonth($data->BrandCode, $data->Month, $ims_percent, $is_ims)) ?></td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content-header">
        <h1>IMS Monthly</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>YTD</th>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Actual Sales</td>
                                    <td><?= number_format(getTotalActualSales($budget_detail->row()->BrandCode, $budget_detail->result()[0]->Month, $budget_detail->result()[11]->Month)) ?></td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <!-- <td><?= $data->BrandCode . '#' . $data->Month ?></td> -->
                                        <td><?= number_format(getActualSalesPerMonth($data->BrandCode, $data->Month)) ?></td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content-header">
        <h1>Budget On Top
            <?php if (get_on_top_is_exists($budget_code)->num_rows() < 1) { ?>
                <a class="btn btn-primary btn-xs" href="<?= base_url($_SESSION['page'] . '/showFormAddOnTop/' . $budget_code); ?>">Add Budget On Top</a>
            <?php } ?>
            <?php if (get_on_top_activity_is_exists($budget_code)->num_rows() > 1) { ?>
                <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#exampleModal">Edit</button>
            <?php } ?>
            <?php if (get_on_top_is_exists($budget_code)->num_rows() > 1 && get_on_top_activity_is_exists($budget_code)->num_rows() < 1) { ?>
                <a href="<?= base_url($_SESSION['page'] . '/set_on_top_activity/' . $budget_code) ?>" class="btn btn-primary btn-xs">Add Activity</a>
            <?php } ?>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Budget On Top</td>
                                    <td><?= number_format(get_total_on_top($budget_code)) ?></td>
                                    <?php foreach (budget_on_top($budget_code)->result() as $data) { ?>
                                        <td><?= number_format($data->budget_on_top) ?></td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Update Budget On Top</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive">
                        <form id="form_edit_on_top">
                            <table class="table table-responsive table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Total</th>
                                        <?php foreach ($budget_detail->result() as $data) { ?>
                                            <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding : 0px !important">
                                            <input id="total_on_top" class="form-control" type="text" value="<?= number_format(get_total_on_top($budget_code)) ?>" readonly>
                                        </td>
                                        <?php foreach (budget_on_top($budget_code)->result() as $data) { ?>

                                            <input name="budget_code[]" type="hidden" value="<?= $data->budget_code ?>">
                                            <input name="month[]" type="hidden" value="<?= $data->month ?>">
                                            <td style="padding : 0px !important">
                                                <input onkeypress="javascript:return isNumber(event)" onkeyup="reset_to_zero(this);formatNumber(this); calculate_total_on_top();" type="text" name="budget_on_top[]" class="form-control on_top" value="<?= number_format($data->budget_on_top) ?>">
                                            </td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button onclick="edit_on_top()" type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content-header">
        <h1>Target Activity</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <!-- <button class="btn btn-success pull-right">Edit</button> -->
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Activity (<?= get_target_activity_percent($budget_code) ?>)</th>
                                    <th>Total</th>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activity->result() as $member_activity) { ?>
                                    <tr>
                                        <td><?= $member_activity->ActivityName ?> (<?= round(getPercentBudgetActivity($member_activity->BudgetCodeActivity) * 100) ?>%)</td>
                                        <td><?= number_format(getTotalOperatingActivity($member_activity->BudgetCodeActivity)) ?></td>
                                        <?php foreach ($budget_detail->result() as $member_budget) { ?>
                                            <td>
                                                <?php
                                                $brand = $member_activity->BrandCode;
                                                $activity_code = $member_activity->ActivityCode;
                                                $month = $member_budget->Month;
                                                ?>
                                                <?= number_format(getOperatingActivity($brand, $activity_code, $month)) ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content-header">
        <h1>Target Activity On Top</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <!-- <button class="btn btn-success pull-right">Edit</button> -->
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Activity (<?= get_on_top_target_activity_percent($budget_code) ?>)</th>
                                    <th>Total</th>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (budget_on_top_activity($budget_code)->result() as $on_top_activity) { ?>
                                    <tr>
                                        <td><?= getActivityName($on_top_activity->id_activity) ?> (<?= $on_top_activity->budget_on_top_percent ?>%)</td>
                                        <td><?= number_format($on_top_activity->on_top_activity) ?></td>
                                        <?php foreach (get_on_top_per_activity_permonth($on_top_activity->budget_code_activity)->result() as $data) { ?>
                                            <td><?= number_format($data->on_top_activity) ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content-header">
        <h1>A&P Tracking</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>A&P Tracking</th>
                                    <?php foreach (getMonthBudget($budget_code)->result() as $mth) { ?>
                                        <th><?= date('M-Y', strtotime($mth->month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A&P Actual</td>
                                    <?php foreach (getMonthBudget($budget_code)->result() as $mth) { ?>
                                        <td><?= number_format(getActualPurchasePerMonth($brand_code, $mth->month) * $target_anp) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>A&P On Top</td>
                                    <?php foreach (getMonthBudget($budget_code)->result() as $mth) { ?>
                                        <td><?= number_format(get_budget_on_top_permonth($brand_code, $mth->month)) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>IMS Actual</td>
                                    <?php foreach (getMonthBudget($budget_code)->result() as $mth) { ?>
                                        <td><?= number_format(getActualIMSPermonth($brand_code, $mth->month, $ims_percent, $is_ims)) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>Operating Budget</td>
                                    <?php foreach (getMonthBudget($budget_code)->result() as $mth) { ?>
                                        <td><?= number_format(get_operating_permonth($brand_code, $mth->month)) ?></td>
                                    <?php } ?>
                                </tr>
                                <!-- <tr>
                                    <td>A&P Booked</td>
                                    <?php foreach (getMonthBudget($budget_code)->result() as $mth) { ?>
                                        <td><?= number_format(get_anp_booked_permonth($budget_code, $mth->month)) ?></td>
                                    <?php } ?>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="box-footer">
                        <div class="col-md-3">
                            <table class="table table-hover">
                                <tr>
                                    <td> YTD A&P Actual <b>(<?= date('M-Y') ?>)</b></td>
                                    <td>&nbsp;:&nbsp; 12.000.000</td>
                                </tr>
                                <tr>
                                    <td> YTD On Top <b>(<?= date('M-Y') ?>)</b></td>
                                    <td>&nbsp;:&nbsp; 15.000.000 </td>
                                </tr>
                                <tr>
                                    <td> YTD IMS Actual <b>(<?= date('M-Y') ?>)</b></td>
                                    <td>&nbsp;:&nbsp; 15.000.000 </td>
                                </tr>
                                <tr>
                                    <td> YTD Opertaing <b>(<?= date('M-Y') ?>)</b></td>
                                    <td>&nbsp;:&nbsp; 15.000.000 </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table>
                                <tr>
                                    <td> Total A&P Actual</td>
                                    <td>&nbsp;:&nbsp; 12.000.000</td>
                                </tr>
                                <tr>
                                    <td> Total On Top</td>
                                    <td>&nbsp;:&nbsp; 15.000.000 </td>
                                </tr>
                                <tr>
                                    <td> Total IMS Actual</td>
                                    <td>&nbsp;:&nbsp; 15.000.000 </td>
                                </tr>
                                <tr>
                                    <td> Total Opertaing </td>
                                    <td>&nbsp;:&nbsp; 15.000.000 </td>
                                </tr>
                            </table>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>



    <section class="content-header">
        <h1>Proposal Tracking On Actual Purchase</h1>
        <!-- <?= date('Y-m-d') ?> -->
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Activity (<?= get_target_activity_percent($budget_code) ?>)</th>
                                    <th>Budget <?= date('Y', strtotime($budget_detail->result()[11]->Month)) ?></th>
                                    <th>YTD <?= date('M-Y') ?></th>
                                    <th>Balance</th>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activity->result() as $member_activity) { ?>
                                    <tr>
                                        <td width="auto"><?= $member_activity->ActivityName ?> (<?= round(getPercentBudgetActivity($member_activity->BudgetCodeActivity) * 100) ?>%)</td>
                                        <td><?= number_format($total_actual_anp * getPercentBudgetActivity($member_activity->BudgetCodeActivity)) ?></td>
                                        <td><?= number_format(getTotalBudgetBookedActivity($member_activity->BudgetCodeActivity)) ?></td>
                                        <td> <?= number_format(($total_actual_anp * getPercentBudgetActivity($member_activity->BudgetCodeActivity)) - (getTotalBudgetBookedActivity($member_activity->BudgetCodeActivity))) ?></td>
                                        <?php foreach ($budget_detail->result() as $member_budget) { ?>
                                            <td><?= number_format(getBudgetBookedActivityPermonth($member_activity->BudgetCodeActivity, $member_budget->Month)) ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content-header">
        <h1>Proposal Tracking On Top</h1>
        <!-- <?= date('Y-m-d') ?> -->
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Activity (<?= get_on_top_target_activity_percent($budget_code) ?>)</th>
                                    <th>Budget <?= date('Y', strtotime($budget_detail->result()[11]->Month)) ?></th>
                                    <th>YTD <?= date('M-Y') ?></th>
                                    <th>Balance</th>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (budget_on_top_activity($budget_code)->result() as $on_top_activity) { ?>
                                    <tr>
                                        <td><?= getActivityName($on_top_activity->id_activity) ?> (<?= $on_top_activity->budget_on_top_percent ?>%)</td>
                                        <td><?= number_format((float)get_total_on_top($budget_code) * ((float)$on_top_activity->budget_on_top_percent / 100)) ?></td>
                                        <td><?= number_format(booked_on_top_per_activity($on_top_activity->budget_code_activity)) ?></td>
                                        <td><?= number_format(((float)get_total_on_top($budget_code) * ((float)$on_top_activity->budget_on_top_percent / 100) - (booked_on_top_per_activity($on_top_activity->budget_code_activity)))) ?></td>
                                        <?php foreach (budget_on_top($budget_code)->result() as $otp) { ?>
                                            <td><?= number_format(get_on_top_booked_per_activity_permonth($budget_code, $on_top_activity->id_activity, $otp->month)) ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</section>
<?php $this->view('footer') ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('.table-target-activity').DataTable({
            // scrollX: true,
        })

        $('.table-tracking-proposal').DataTable({
            // scrollX: true,
        });
    });

    function calculate_total_on_top() {
        var input_total_on_top = document.getElementById('total_on_top');
        var input_on_top = document.querySelectorAll('input.on_top');
        var total_on_top = 0;
        for (var i = 0; i < input_on_top.length; i++) {
            total_on_top += parseFloat(input_on_top[i].value.replace(/,/g, ''));
        }
        document.getElementById('total_on_top').value = total_on_top.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function edit_on_top() {
        var form = new FormData(document.getElementById('form_edit_on_top'));
        $.ajax({
            url: '<?= base_url($_SESSION['page'] . '/update_on_top') ?>',
            data: form,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {
                if (response.success == true) {
                    // return false;
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data berhasil Disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "<?= base_url($_SESSION['page'] . '/ShowDetailBudget/' . $budget_code); ?>";
                        loadingShow()
                    })
                } else if (response.total_on_top == 'lebih_kecil') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Total budget baru lebih kecil dari sebelumnya',
                    })
                    return false;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Data gagal disimpan!',
                    })
                }
            }
        });
    }
</script>