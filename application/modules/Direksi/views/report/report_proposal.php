<?php $this->view('header') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            All Proposal
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Invoice</li>
        </ol> -->
    </section>

    <!-- <div class="pad margin no-print">
        <div class="callout callout-info" style="margin-bottom: 0!important;">
            <h4><i class="fa fa-info"></i> Note:</h4>
            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
        </div>
    </div> -->

    <?php foreach ($proposal->result() as $data) { ?>

        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <?= $data->Number ?>
                        <small class="pull-right">Cretated Date: <?= $data->CreatedDate ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-3 invoice-col">
                    <address>
                        Brand : <strong><?= $data->BrandName ?></strong><br>
                        Activity : <strong><?= $data->promo_name ?></strong><br>
                        Start Periode : <strong><?= $data->StartPeriode ?></strong><br>
                        End Periode : <strong><?= $data->EndPeriode ?></strong><br>
                        Status : <strong><?= $data->Status ?></strong><br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                    <address>
                        <strong>Objective</strong><br>
                        <?php foreach (get_proposal_objective($data->Number)->result() as $ob) { ?>
                            <?= ucfirst($ob->Objective) ?><br>
                        <?php } ?>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                    <address>
                        <strong>Mechanism</strong><br>
                        <?php foreach (get_proposal_mechanism($data->Number)->result() as $me) { ?>
                            <?= ucfirst($me->Mechanism) ?><br>
                        <?php } ?>
                    </address>
                </div>
                <div class="col-sm-3 invoice-col">
                    <address>
                        <strong>Comment</strong><br>
                        <?php foreach (get_proposal_comment($data->Number)->result() as $com) { ?>
                            <?= ucfirst($com->Comment) ?><br>
                        <?php } ?>
                    </address>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <strong>Product Items</strong>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Barcode</th>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Value</th>
                                <th>Costing</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach (getItemProposal($data->Number)->result() as $item) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $item->Barcode ?></td>
                                    <td><?= $item->ItemName ?></td>
                                    <td><?= number_format($item->Price) ?></td>
                                    <td><?= number_format($item->Qty) ?></td>
                                    <td><?= number_format($item->PromoValue) ?></td>
                                    <td><?= number_format($item->Costing) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->

                <div class="col-md-5 col-xs-12 table-responsive">
                    <strong>Costing lain-lain</strong>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Desc</th>
                                <th>Costing</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $o = 1;
                            foreach (getProposalCostingOther($data->Number)->result() as $ot) { ?>
                                <tr>
                                    <td><?= $o++ ?></td>
                                    <td><?= ucfirst($ot->Desc) ?></td>
                                    <td><?= number_format($ot->Costing) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-7 col-xs-12 table-responsive">
                    <strong>Detail Item By Group</strong>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Group Name</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1;
                            foreach (getItemGroup($data->Number)->result() as $ig) { ?>
                                <tr>
                                    <td><?= $c++ ?></td>
                                    <td><?= $ig->GroupName ?></td>
                                    <td><?= $ig->ItemName ?></td>
                                    <td><?= $ig->Target ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-4">
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        TOTAL COSTING : <strong><?= number_format($data->TotalCosting) ?></strong>
                    </p>

                    <!-- <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        Approved By:
                    </p> -->
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <!-- <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
                </button>
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generate PDF
                </button> -->
                </div>
            </div>
        </section>

    <?php } ?>
    <!-- /.content -->





    <div class="clearfix"></div>
</div>
<?php $this->view('footer') ?>