<?php 
    // var_dump($_SERVER);
?>
<?php $this->view('header') ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="content-header">
                <div class="row">
                    <div class="col col-md-6">
                        <h4>Data Proposal Detail</h4>
                    </div>
                    <div class="col col-md-6">
                        <a href="<?=$_SERVER['HTTP_REFERER']?>" class="btn btn-warning pull-right">Back</a>
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
                                    <tr>
                                        <td>Balance Activity</td>
                                        <td>&nbsp;:&nbsp;<b><?= number_format(proposal_maked($proposal->row()->Number)->row()->Budget_saldo) ?></b> (<?= $budget_source ?>)</td>
                                    </tr>
                                    <tr>
                                        <td>Costing</td>
                                        <td>&nbsp;:&nbsp;<b><?= number_format($operatingProposal->row()->TotalCosting) ?></b></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-4">
                                <?php if ($approvedBy->num_rows() > 0) { ?>
                                    <b>Approved By</b>
                                    <p><?= ucwords($proposal->row()->ApprovedBy) ?></p>
                                <?php } ?>
                                <?php if ($proposal->row()->Status == 'cancelled') { ?>
                                    <b>Cancell By </b>
                                    <p><?= ucwords($proposal->row()->CancelBy) ?></p>
                                <?php } ?>
                            </div>
                            <div class="col-md-4">
                                <?php if ($proposal->row()->Status == 'open') { ?>
                                    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-approved">Approve</button>
                                    <button class="btn btn-danger pull-right" data-toggle="modal" data-target="#modal-cancel" style="margin-right:5px">Cancel</button>
                                    <!-- <a href="<?= base_url($_SESSION['page']) . '/approveProposal/' . $proposal->row()->Number ?>" class="btn btn-primary pull-right pull-bottom" style="margin-left:5px;">Approve</a>
                                    <a href="<?= base_url($_SESSION['page']) . '/cancelProposal/' . $proposal->row()->Number ?>" class="btn btn-danger pull-right">Cancel</a> -->
                                <?php } else { ?>
                                    <div class="">
                                        <b>Comment</b>
                                        <p><?= ucwords($proposal->row()->reason) ?></p>
                                    </div>
                                <?php } ?>
                                <div class="modal fade" id="modal-approved">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Comment</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <form id="form_approve">
                                                        <input type="hidden" name="number" value="<?= $proposal->row()->Number ?>">
                                                        <textarea name="comment" class="form-control" rows="3" placeholder="Enter ..."></textarea>
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
                                <h3>Items</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-responseive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Item Code</th>
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
                                                <th>Promo(%)</th>
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
                                                <td><?= $item->ItemCode ?></td>
                                                <td><?= $item->Barcode ?></td>
                                                <td><?= $item->ItemName ?></td>
                                                <td><?= number_format($item->Price) ?></td>
                                                <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                    <td><?= number_format($item->AvgSales) ?></td>
                                                <?php } ?>
                                                <td class="item_qty"><?= number_format($item->Qty) ?></td>
                                                <td class="item_target"><?= number_format($item->Target) ?></td>
                                                <?php if (activity_is_sales($proposal->row()->Activity) == 'N') {  ?>
                                                    <td>
                                                        <?= number_format($item->ListingCost)  ?>
                                                    </td>
                                                <?php } ?>
                                                <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                    <td><?= $item->Promo ?></td>
                                                    <td class="item_value"><?= number_format(($item->Promo / 100) * $item->Price) ?></td>
                                                <?php } ?>
                                                <td class="item_costing"><?= number_format($item->Costing) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfooter>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td id="total_qty"></td>
                                            <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                <td></td>
                                            <?php } ?>
                                            <td id="total_target">
                                                <?= number_format(total_target($proposal->row()->Number)) ?>
                                            </td>
                                            <?php if (activity_is_sales($proposal->row()->Activity) == 'N') { ?>
                                                <td></td>
                                            <?php } ?>
                                            <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                <td></td>
                                                <td id="total_value"></td>
                                            <?php } ?>
                                            <td id="total_costing">
                                                <?= number_format(total_costing($proposal->row()->Number)) ?>
                                            </td>
                                        </tr>
                                    </tfooter>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <table>
                                    <tr>
                                        <td>COST RATIO</td>
                                        <td>&nbsp;:&nbsp; <b id="cost_ratio"><?= cost_ratio($proposal->row()->Number) ?></b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3>Customer</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-responseive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Group Code</th>
                                            <th>Group Name</th>
                                            <th>Customer Name</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyCustomer">
                                        <?php $num = 1;
                                        foreach ($proposalCustomer->result() as $customer) { ?>
                                            <tr>
                                                <td><?= $num++ ?></td>
                                                <td><?= $customer->GroupCustomer ?></td>
                                                <td><?= $customer->GroupName ?></td>
                                                <td><?= $customer->CustomerName ?></td>
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


    // var td_item_qty = document.querySelectorAll('td.item_qty');
    // var td_item_target = document.querySelectorAll('td.item_target');
    // var td_item_value = document.querySelectorAll('td.item_value');
    // var td_item_costing = document.querySelectorAll('td.item_costing');

    // var total_qty = 0;
    // var total_target = 0;
    // var total_value = 0;
    // var total_costing = 0;

    // for (var i = 0; i < td_item_target.length; i++) {
    //     total_qty += parseFloat(td_item_qty[i].innerText.replace(/,/g, ''))
    //     total_target += parseFloat(td_item_target[i].innerText.replace(/,/g, ''))
    //     total_value += parseFloat(td_item_value[i].innerText.replace(/,/g, ''))
    //     total_costing += parseFloat(td_item_costing[i].innerText.replace(/,/g, ''))
    // }

    // document.querySelector('td#total_qty').innerText = total_qty.toLocaleString();
    // document.querySelector('td#total_target').innerText = total_target.toLocaleString();
    // document.querySelector('td#total_value').innerText = total_value.toLocaleString();
    // document.querySelector('td#total_costing').innerText = total_costing.toLocaleString();
    // document.getElementById('cost_ratio').innerText = Math.round(((total_costing / total_target) * 100)) + '%';
</script>