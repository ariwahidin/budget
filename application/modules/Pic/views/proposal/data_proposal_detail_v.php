<!-- <?php var_dump(activity_is_sales($proposal->row()->Activity)) ?> -->
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
                <?php if ($proposal->row()->Status == 'approved') { ?>
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default" style="margin-right: 10px;"> Add No.SK</button>
                <?php } ?>
                <h1>Data Proposal Detail</h1>
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
                                        </table>
                                    </div>
                                    <?php if ($proposal->row()->Status != 'open') { ?>
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
                                            <div class="">
                                                <b>Comment</b>
                                                <p><?= ucwords($proposal->row()->reason) ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
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
                                <table class="table table-responseive table-bordered table-striped table_customer">
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
                                                <td><?= $customer->no_sk ?></td>
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
                        <?php if ($proposal->row()->Status == 'approved') { ?>
                            <a href="<?= base_url($_SESSION['page']) . '/exportProposalToPdf/' . $proposal->row()->Number ?>" class="btn btn-danger pull-right" style="margin-left:5px;">Export to Pdf</a>
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
                <h4 class="modal-title">Customer</h4>
            </div>
            <form action="<?= base_url($_SESSION['page']) . '/prosesNoSk' ?>" method="POST" id="formProsesNoSk">
                <input type="hidden" name="no_proposal" value="<?= $proposal->row()->Number ?>">
                <div class="modal-body">
                    <!-- <p>One fine body&hellip;</p> -->
                    <div class="box box-primary">
                        <div class="box-body">
                            <table class="table">
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
    <!-- /.modal-dialog -->
</div>

<?php $this->view('footer') ?>
<script>
    $(document).ready(function() {
        $('.table_customer').DataTable()
    });

    function prosesSK() {
        var form = $('#formProsesNoSk')
        form.submit()
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

    // document.querySelector('td#total_qty').innerText = total_qty.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // document.querySelector('td#total_target').innerText = total_target.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // document.querySelector('td#total_value').innerText = total_value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // document.querySelector('td#total_costing').innerText = total_costing.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // document.getElementById('cost_ratio').innerText = ((total_costing / total_target) * 100).toFixed(2) + '%';
</script>