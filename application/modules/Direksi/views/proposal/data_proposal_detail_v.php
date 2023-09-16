<?php
// var_dump($_SESSION);
?>
<?php $this->view('header') ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="content-header">
                <div class="row">
                    <div class="col col-md-6">
                        <h4 style="font-weight: bold;">
                            Proposal Detail
                        </h4>
                    </div>
                    <div class="col col-md-6">
                        <button class="btn btn-warning btn-sm pull-right" id="btnBack">Back</button>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="box">
                    <div class="row">
                        <div class="box-body">
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <td>No Proposal</td>
                                        <td>&nbsp;:&nbsp;<b><?= $proposal->row()->Number ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Brand</td>
                                        <td>&nbsp;:&nbsp;<b><?= getBrandName($proposal->row()->BrandCode) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Activity</td>
                                        <td>&nbsp;:&nbsp;<b><?= getActivityName($proposal->row()->Activity) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Start Periode</td>
                                        <td>&nbsp;:&nbsp;<b><?= date('d-M-Y', strtotime($proposal->row()->StartDatePeriode)) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>End Periode</td>
                                        <td>&nbsp;:&nbsp;<b><?= date('d-M-Y', strtotime($proposal->row()->EndDatePeriode)) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>&nbsp;:&nbsp;<b><?= ucfirst($proposal->row()->Status) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Claim to</td>
                                        <td>&nbsp;:&nbsp;<b><?= ucfirst($proposal->row()->ClaimTo) ?></b></td>
                                    </tr>
                                    <!-- <tr>
                                        <td>Operarting</td>
                                        <td>&nbsp;:&nbsp;<b><?= number_format(proposal_maked($proposal->row()->Number)->row()->Budget_saldo) ?></b></td>
                                    </tr> -->
                                    <tr>
                                        <td>Costing</td>
                                        <td>&nbsp;:&nbsp;<b><?= number_format($operatingProposal->row()->TotalCosting) ?></b></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-4">
                                <?php if ($approvedBy->num_rows() > 0) { ?>
                                    <b>Approved By</b>
                                    <ul>
                                        <?php foreach ($approvedBy->result() as $data) { ?>
                                            <li><?= ucwords($data->username) ?></li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                                <?php if ($proposal->row()->Status == 'canceled') { ?>
                                    <b>Cancel By </b>
                                    <p><?= ucwords($proposal->row()->CancelBy) ?></p>
                                <?php } ?>
                            </div>
                            <div class="col-md-4">

                                <?php
                                if ($approvedBy->num_rows() > 0) {
                                    $array_user = array();
                                    foreach ($approvedBy->result() as $data) {
                                        array_push($array_user, $data->created_by);
                                    }
                                    if (array_search($this->session->userdata('user_code'), $array_user) !== false) {
                                        //do nothing
                                    } else {
                                        //do something
                                ?>
                                        <?php if ($proposal->row()->Status == 'rejected') { ?>
                                            <!-- //do nothing -->
                                        <?php } else { ?>
                                            <button style="margin-left: 5px;" class="btn btn-danger pull-right" data-toggle="modal" data-target="#modal-reject">Reject</button>
                                            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-approved">Approve</button>
                                        <?php } ?>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <button style="margin-left: 5px;" class="btn btn-danger pull-right" data-toggle="modal" data-target="#modal-reject">Reject</button>
                                    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-approved">Approve</button>
                                <?php
                                }
                                ?>

                                <?php if ($approvedBy->num_rows() > 0) { ?>
                                    <div class="">
                                        <b>Comment</b>
                                        <ul>
                                            <?php foreach ($approvedBy->result() as $data) { ?>
                                                <li><?= ucwords($data->reason) ?></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>

                                <?php if ($proposal->row()->Status == 'open') { ?>
                                    <!-- <button class="btn btn-danger pull-right" data-toggle="modal" data-target="#modal-cancel" style="margin-right:5px">Cancel</button> -->
                                    <!-- <a href="<?= base_url($_SESSION['page']) . '/approveProposal/' . $proposal->row()->Number ?>" class="btn btn-primary pull-right pull-bottom" style="margin-left:5px;">Approve</a> -->
                                    <!-- <a href="<?= base_url($_SESSION['page']) . '/cancelProposal/' . $proposal->row()->Number ?>" class="btn btn-danger pull-right">Cancel</a> -->
                                <?php } else { ?>
                                <?php } ?>

                                <div class="modal fade" id="modal-approved">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Approve proposal</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <form id="form_approve">
                                                        <input type="hidden" name="number" value="<?= $proposal->row()->Number ?>">
                                                        <textarea name="comment" class="form-control" rows="3" placeholder="Enter a reason"></textarea>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                <button onclick="approve_proposal()" type="button" class="btn btn-primary">Approve</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-reject">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Reject proposal</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <form id="form_reject">
                                                        <input type="hidden" name="number" value="<?= $proposal->row()->Number ?>">
                                                        <textarea name="comment" class="form-control" rows="3" placeholder="Enter a reason"></textarea>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                <button onclick="reject_proposal()" type="button" class="btn btn-danger">Reject</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-cancel">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Comment</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <form id="form_cancel">
                                                        <input type="hidden" name="number" value="<?= $proposal->row()->Number ?>">
                                                        <textarea name="comment" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                <button onclick="cancel_proposal()" type="button" class="btn btn-danger">Cancel Proposal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <table>
                                    <tr>
                                        <th colspan="2">Objective</th>
                                    </tr>
                                    <?php $no = 1;
                                    foreach (get_proposal_objective($proposal->row()->Number)->result() as $obj) { ?>
                                        <tr>
                                            <td><?= $no++ ?>.&nbsp;</td>
                                            <td><?= $obj->Objective ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <br>
                                <table>
                                    <tr>
                                        <th colspan="2">Promo Mechanism</th>
                                    </tr>
                                    <?php $no = 1;
                                    foreach (get_proposal_mechanism($proposal->row()->Number)->result() as $mek) { ?>
                                        <tr>
                                            <td><?= $no++ ?>.&nbsp;</td>
                                            <td><?= $mek->Mechanism ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <br>
                                <table>
                                    <tr>
                                        <th colspan="2">Comment</th>
                                    </tr>
                                    <?php $no = 1;
                                    foreach (get_proposal_comment($proposal->row()->Number)->result() as $com) { ?>
                                        <tr>
                                            <td><?= $no++ ?>.&nbsp;</td>
                                            <td><?= $com->Comment ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <strong>Target And Costing Product Items</strong>
                            </div>
                            <div class="box-body table-responsive">
                                <table class="table table-responsive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Barcode</th>
                                            <th>Item Name</th>
                                            <th>Price</th>
                                            <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                <th><?= $proposal->row()->AvgSales ?></th>
                                            <?php } ?>
                                            <th>Qty</th>
                                            <th>Target</th>
                                            <?php if (activity_is_sales($proposal->row()->Activity) == 'N') { ?>
                                                <th><?= getActivityName($proposal->row()->Activity) ?> Cost</th>
                                            <?php } ?>
                                            <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                <th>(%)</th>
                                                <th>Value</th>
                                            <?php } ?>
                                            <th>Costing</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyItem">
                                        <?php $no = 1;
                                        foreach ($proposalItem->result() as $item) { ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $item->Barcode ?></td>
                                                <td><?= $item->ItemName ?></td>
                                                <td style="text-align: right;"><?= number_format($item->Price) ?></td>
                                                <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                    <td style="text-align: right;"><?= number_format($item->AvgSales) ?></td>
                                                <?php } ?>
                                                <td style="text-align: right;" class="item_qty"><?= number_format($item->Qty) ?></td>
                                                <td style="text-align: right;" class="item_target"><?= number_format($item->Target) ?></td>
                                                <?php if (activity_is_sales($proposal->row()->Activity) == 'N') {  ?>
                                                    <td style="text-align: right;">
                                                        <?= number_format($item->ListingCost)  ?>
                                                    </td>
                                                <?php } ?>
                                                <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                    <td style="text-align: right;"><?= $item->Promo ?></td>
                                                    <td style="text-align: right;" class="item_value"><?= number_format($item->PromoValue) ?></td>
                                                <?php } ?>
                                                <td style="text-align: right;" class="item_costing"><?= number_format($item->Costing) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfooter>
                                        <tr>
                                            <td>
                                                <b>
                                                    Total
                                                </b>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td id="total_qty"></td>
                                            <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                <td></td>
                                            <?php } ?>
                                            <td style="text-align: right;" id="total_target">
                                                <b>
                                                    <?= number_format(total_target($proposal->row()->Number)) ?>
                                                </b>
                                            </td>
                                            <?php if (activity_is_sales($proposal->row()->Activity) == 'N') { ?>
                                                <td></td>
                                            <?php } ?>
                                            <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                <td></td>
                                                <td id="total_value"></td>
                                            <?php } ?>
                                            <td style="text-align: right;" id="total_costing">
                                                <b>
                                                    <?= number_format(total_costing($proposal->row()->Number)) ?>
                                                </b>
                                            </td>
                                        </tr>
                                    </tfooter>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="box">
                            <div class="box-header">
                                <strong>
                                    Costing Lain -lain
                                </strong>
                            </div>
                            <div class="box-body table-responsive">

                                <table class="table table-responsive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Description</th>
                                            <th>Costing</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totalCostingOther = 0;
                                        $no = 1;
                                        foreach ($costingOther->result() as $data) {
                                            $totalCostingOther += $data->Costing;
                                        ?>
                                            <tr>
                                                <td style="width: 35px;"><?= $no++ ?></td>
                                                <td><?= $data->Desc ?></td>
                                                <td><?= number_format($data->Costing) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfooter>
                                        <tr>
                                            <td colspan="2">
                                                <b>
                                                    Total
                                                </b>
                                            </td>
                                            <td style="text-align: right;">
                                                <b>
                                                    <?= number_format($totalCostingOther) ?>
                                                </b>
                                            </td>
                                        </tr>
                                    </tfooter>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <strong>
                                    Customer
                                </strong>
                            </div>
                            <div class="box-body table-responsive">
                                <table class="table table-responsive table-bordered table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Group Name</th>
                                            <th>Customer Name</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyCustomer">
                                        <?php $num = 1;
                                        foreach ($proposalCustomer->result() as $customer) { ?>
                                            <tr>
                                                <td><?= $num++ ?></td>
                                                <td><?= $customer->GroupName ?></td>
                                                <td><?= $customer->CustomerName ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <strong>Detail Item By Group Customer</strong>
                            </div>
                            <div class="box-body table-responsive">
                                <table class="table table-responsive table-bordered table-striped" id="tableDetailItem">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Group Customer</th>
                                            <th>Item Name</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($itemGroup->result() as $data) { ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $data->GroupName ?></td>
                                                <td><?= $data->ItemName ?></td>
                                                <td style="text-align: right;"><?= $data->Target ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php $this->view('footer') ?>
<script>
    $(document).ready(function() {
        $('#tableDetailItem').DataTable()
        $('#btnBack').on('click', function() {
            history.back()
        })
    })

    function approve_proposal() {
        var form = new FormData(document.getElementById('form_approve'));
        $.ajax({
            url: '<?= base_url($_SESSION['page']) . '/approveProposal/' . $proposal->row()->Number ?>',
            data: form,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {
                if (response.success == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Approved',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "<?= base_url($_SESSION['page'] . '/showProposalDetail/' . $proposal->row()->Number); ?>";
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                    })
                }
            }
        });
    }

    function reject_proposal() {
        var form = new FormData(document.getElementById('form_reject'));
        $.ajax({
            url: '<?= base_url($_SESSION['page']) . '/rejectProposal/' . $proposal->row()->Number ?>',
            data: form,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {
                if (response.success == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proposal rejected',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "<?= base_url($_SESSION['page'] . '/showProposalDetail/' . $proposal->row()->Number); ?>";
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                    })
                }
            }
        });
    }

    function cancel_proposal() {
        var form = new FormData(document.getElementById('form_cancel'));
        $.ajax({
            url: '<?= base_url($_SESSION['page']) . '/cancelProposal/' . $proposal->row()->Number ?>',
            data: form,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {
                if (response.success == true) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Cancelled',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "<?= base_url($_SESSION['page'] . '/showProposalDetail/' . $proposal->row()->Number); ?>";
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                    })
                }
            }
        });
    }
</script>