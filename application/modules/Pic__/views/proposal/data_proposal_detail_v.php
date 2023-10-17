<?php $this->view('header') ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="content-header">
                <?php
                $this->view('messages');
                ?>
                <a class="btn bg-orange pull-right" href="<?= base_url($_SESSION['page'] . '/showProposal') ?>" style="margin-right:5px;">Back</a>

                <?php if ($proposal->row()->Status == 'open' || $proposal->row()->Status == 'cancelled') { ?>
                    <!-- <a class="btn btn-warning pull-right" href="<?= base_url($_SESSION['page'] . '/edit_proposal/' . $proposal->row()->Number) ?>" style="margin-right:5px;">Edit</a> -->
                <?php } ?>
                <!-- <?php if ($proposal->row()->Status == 'approved') { ?>
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default" style="margin-right: 10px;"> Add No.SK</button>
                <?php } ?> -->
                <h4>
                    <strong>Proposal Detail </strong>
                    <!-- <button onclick="copyTo(this)" data-number="<?= $proposal->row()->Number ?>" class="btn btn-sm btn-success">Copy To</button> -->
                </h4>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <table>
                                            <tr>
                                                <td>No Proposal</td>
                                                <td>&nbsp;:&nbsp;<b><?= $proposal->row()->Number ?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Ref Code</td>
                                                <td>&nbsp;:&nbsp;<b><?= $proposal->row()->NoRef ?></b></td>
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
                                                <td>Claim To</td>
                                                <td>&nbsp;:&nbsp;<b><?= ucfirst($proposal->row()->ClaimTo) ?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Total Costing</td>
                                                <td>&nbsp;:&nbsp;<b><?= number_format($total_costing) ?></b></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Approved by</th>
                                                    <th>Comment</th>
                                                    <th>Approved date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                foreach ($approvedBy->result() as $data) { ?>
                                                    <tr>
                                                        <td><?= $no++ . "." ?></td>
                                                        <td><?= ucfirst($data->fullname) ?></td>
                                                        <td><?= ucfirst($data->reason) ?></td>
                                                        <td><?= date('d M Y H:i', strtotime($data->approvedDate)) ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <?php if ($proposal->row()->Status != 'open') { ?>
                                        <div class="col-md-4">
                                            <?php if ($approvedBy->num_rows() > 0) { ?>
                                                <b>Approved By</b>
                                                <ul>
                                                    <?php foreach ($approvedBy->result() as $data) { ?>
                                                        <li><?= ucwords($data->fullname) ?></li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } ?>
                                            <?php if ($proposal->row()->Status == 'cancelled') { ?>
                                                <b>Cancell By </b>
                                                <p><?= ucwords($proposal->row()->CancelBy) ?></p>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="">
                                                <b>Comment</b>
                                                <?php if ($approvedBy->num_rows() > 0) { ?>
                                                    <b>Approved By</b>
                                                    <ul>
                                                        <?php foreach ($approvedBy->result() as $data) { ?>
                                                            <li><?= ucwords($data->reason) ?></li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?> -->
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
                                    foreach ($objective->result() as $obj) { ?>
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
                                    foreach ($mechanism->result() as $mek) { ?>
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
                                    foreach ($comment->result() as $com) { ?>
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
                        <?php if ($proposalItem->num_rows() > 0) { ?>
                            <div class="box">
                                <div class="box-header">
                                    <strong>Target and costing product</strong>
                                </div>
                                <div class="box-body table-responsive">
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
                                            // var_dump($proposalItem->result());
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
                                                        <!-- <td class="item_value"><?= number_format(($item->Promo / 100) * $item->Price) ?></td> -->
                                                        <td class="item_value"><?= number_format($item->PromoValue) ?></td>
                                                    <?php } ?>
                                                    <td class="item_costing"><?= number_format($item->Costing) ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                                <td colspan="5">
                                                    <strong>
                                                        Total
                                                    </strong>
                                                </td>

                                                <td id="total_qty"></td>
                                                <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                    <td></td>
                                                <?php } ?>
                                                <td id="total_target">
                                                    <strong>
                                                        <?= number_format(total_target($proposal->row()->Number)) ?>
                                                    </strong>
                                                </td>
                                                <?php if (activity_is_sales($proposal->row()->Activity) == 'N') { ?>
                                                    <td></td>
                                                <?php } ?>
                                                <?php if (activity_is_sales($proposal->row()->Activity) != 'N') { ?>
                                                    <td></td>
                                                    <td id="total_value"></td>
                                                <?php } ?>
                                                <td id="total_costing">
                                                    <strong>
                                                        <?= number_format(total_costing($proposal->row()->Number)) ?>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <table>
                                        <tr>
                                            <!-- <td>COST RATIO</td> -->
                                            <!-- <td>&nbsp;:&nbsp; <b id="cost_ratio"><?= cost_ratio($proposal->row()->Number) ?></b></td> -->
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <strong>Costing lain-lain</strong>
                            </div>
                            <div class="box-body">
                                <table class="table table-responseive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Desc</th>
                                            <th>Costing</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totalCostingOther = 0;
                                        $num = 1;
                                        foreach ($proposalItemOther->result() as $io) {
                                            $totalCostingOther += $io->Costing;
                                        ?>
                                            <tr>
                                                <td style="width:35px;"><?= $num++ ?></td>
                                                <td><?= $io->Desc ?></td>
                                                <td><?= number_format($io->Costing) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfooter>
                                        <tr>
                                            <td colspan="2">
                                                <strong>
                                                    Total
                                                </strong>
                                            </td>

                                            <td>
                                                <strong>
                                                    <?= number_format($totalCostingOther) ?>
                                                </strong>
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
                                <strong>Customer</strong>
                            </div>
                            <div class="box-body">
                                <table class="table table-responseive table-bordered table-striped table_customer" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Group Name</th>
                                            <th>Customer Name</th>
                                            <th>No.SK</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyCustomer">
                                        <?php $num = 1;
                                        foreach ($proposalCustomer->result() as $customer) { ?>
                                            <tr>
                                                <td><?= $num++ ?></td>
                                                <td><?= $customer->GroupName ?></td>
                                                <td><?= $customer->CustomerName ?></td>
                                                <td><?= $customer->no_sk ?></td>
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
                                                <td><?= $data->Target ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="<?= base_url($_SESSION['page']) . '/exportProposalToPdf/' . $proposal->row()->Number ?>" class="btn btn-danger pull-right" style="margin-left:5px;">Export to Pdf</a>
                        <?php if ($proposal->row()->Status == 'approved') { ?>
                            <a href="<?= base_url($_SESSION['page']) . '/exportProposalToExcel/' . $proposal->row()->Number ?>" class="btn btn-success pull-right">Export to Excel</a>
                        <?php } ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Customers</h4>
            </div>
            <form action="<?= base_url($_SESSION['page']) . '/prosesNoSk' ?>" method="POST" id="formProsesNoSk">
                <input type="hidden" name="no_proposal" value="<?= $proposal->row()->Number ?>">
                <div class="modal-body">
                    <div class="box box-primary">
                        <div class="box-body">
                            <table class="table" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Group Code</th>
                                        <th>Group Name</th>
                                        <th>Customer Name</th>
                                        <th>No.SK</th>
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
                                            <td>
                                                <input type="hidden" name="id[]" value="<?= $customer->id ?>">
                                                <input type="text" class="form-control" value="<?= $customer->no_sk ?>" name="no_sk[]" required autocomplete="off">
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>


<div class="modal fade" id="modal_copy_to" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Copy to new proposal</h4>
            </div>
            <div class="modal-body">
                <form id="frm-example" name="frm-example">
                    <div class="form-group">
                        <label for="">Start Periode</label>
                        <input type="date" id="start_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">End Periode</label>
                        <input type="date" id="end_date" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="copyToNewProposal(this)" data-source="<?= $proposal->row()->Budget_type = 'operating' ? 'anp' : $proposal->row()->Budget_type ?>" data-brand="<?= $proposal->row()->BrandCode ?>" data-activity="<?= $proposal->row()->Activity ?>" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>

<form action="<?= base_url($_SESSION['page']) ?>/show_form_proposal_from_sales" method="POST" id="createNewProposal">
    <input type="hidden" name="json_group" value="<?= htmlentities($string_group) ?>">
    <input type="hidden" name="json_customer" value="<?= htmlentities($string_customer) ?>">
</form>

<?php $this->view('footer') ?>
<script>
    $(document).ready(function() {
        $('.table_customer').DataTable({resposive : true})
        $('#tableDetailItem').DataTable({resposive : true})
    });

    function prosesSK() {
        var form = $('#formProsesNoSk')
        form.submit()
    }

    function copyTo() {
        $('#modal_copy_to').modal('show')
    }

    function copyToNewProposal(button) {
        var budget_source = $(button).data('source')
        var brand = $(button).data('brand')
        var activity = $(button).data('activity')
        var start_date = $('#start_date').val()
        var end_date = $('#end_date').val()



        if (start_date.trim() != "" && end_date.trim() != "") {
            $.ajax({
                url: "<?= base_url($_SESSION['page']) ?>/get_budget",
                method: "POST",
                data: {
                    budget_source,
                    brand,
                    activity,
                    start_date,
                    end_date
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.budget == 'not_set') {

                    } else if (response.budget == 'ready') {


                        $('#createNewProposal').submit()
                    }
                }
            })
        }
    }
</script>