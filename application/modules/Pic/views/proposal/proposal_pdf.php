<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/dist/img/pandurasa_kharisma_pt.png">
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    <style>
        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #tb {
            width: auto;
        }

        #tb,
        #tb td,
        #tb th {
            border-collapse: collapse;
            border: 1px solid black;
            padding: 5px;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        /* #table tr:nth-child(even) {
            background-color: #f2f2f2;
        } */

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            /* background-color: #4CAF50; */
            /* color: white; */
        }

        table {
            font-size: x-small;
        }

        td {
            padding: 0;
        }
    </style>
</head>

<body>
    <!-- <?php var_dump($proposal_item->result()); ?> -->


    <div>
        <img src="<?= base_url() ?>assets/dist/img/pandurasa_kharisma_pt.png" style="max-width:30px; padding-bottom:-10px;" alt="">
        <span style="font-size:12px;"><strong> PT.PANDURASA KHARISMA</strong></span>
    </div>
    <div>
        <span style="font-size:12px; float: right; margin-top:-15px;"><?= date('d/m/Y') ?></span>
    </div>
    <hr>


    <div style="text-align:center">
        <h3 style="font-size:24px;"> <b>PROPOSAL PROMOTION</b> </h3>
    </div>
    <div>
        <table>
            <tr>
                <td>NO.</td>
                <td>&nbsp;:&nbsp;<?= $proposal_header->row()->Number ?></td>

            </tr>
            <tr>
                <td>BRAND</td>
                <td>&nbsp;:&nbsp;<?= getBrandName($proposal_header->row()->BrandCode) ?></td>
            </tr>
            <tr>
                <td>PERIODE</td>
                <td>&nbsp;:&nbsp;<?= date('d-m-Y', strtotime($proposal_header->row()->StartDatePeriode)) . ' s/d ' . date('d-m-Y', strtotime($proposal_header->row()->EndDatePeriode)) ?></td>
            </tr>
            <tr>
                <td>PIC</td>
                <td>&nbsp;:&nbsp;<?= ucfirst($proposal_header->row()->CreatedBy) ?></td>
            </tr>
            <tr>
                <td>ACTIVITY</td>
                <td>&nbsp;:&nbsp;<?= getActivityName($proposal_header->row()->Activity) ?></td>
            </tr>
            <tr style="display:none">
                <td>Claim to</td>
                <td>&nbsp;:&nbsp;<?= ucfirst($proposal_header->row()->ClaimTo) ?></td>
            </tr>
            <tr>
                <td>STATUS</td>
                <td>&nbsp;:&nbsp;<?= ucfirst($proposal_header->row()->Status) ?></td>
            </tr>
        </table>
    </div>
    <div>
        <table style="display:none">
            <tr>
                <td>Balance <?= getActivityName($proposal_header->row()->Activity) ?></td>
                <td>&nbsp;:&nbsp;<?= number_format(proposal_approved($proposal_header->row()->Number)->row()->Budget_balance) ?> (<?= proposal_approved($proposal_header->row()->Number)->row()->Budget_type ?>)</td>
            </tr>
        </table>
    </div>
    <div>
        <table>
            <tr>
                <th colspan="4">OBJECTIVE</th>
            </tr>
            <?php $no = 1;
            foreach ($objective->result() as $obj) { ?>
                <tr>
                    <td><?= $no++ ?>.&nbsp;</td>
                    <td><?= $obj->Objective ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th colspan="2">MECHANISM</th>
            </tr>
            <?php $no = 1;
            foreach ($mechanism->result() as $mek) { ?>
                <tr>
                    <td><?= $no++ ?>.</td>
                    <td><?= $mek->Mechanism ?></td>
                </tr>
            <?php } ?>
        </table>
        <table style="float: right;">

        </table>
    </div>
    <div>
        <table>
            <tr>
                <th colspan="3">COMMENT</th>
            </tr>

            <?php
            $no = 1;
            foreach ($comment->result() as $com) { ?>
                <tr>
                    <td><?= $no++ ?>.&nbsp;</td>
                    <td><?= $com->Comment ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div style="text-align:left; padding-top: 10px;">
        <b style="font-size: 12px;">SALES TARGET</b>
    </div>
    <table id="tb">
        <thead>
            <tr>
                <th>No.</th>
                <th>Barcode</th>
                <th>Product Description</th>
                <th>Price</th>
                <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                    <th><?= $proposal_header->row()->AvgSales ?></th>
                <?php } ?>
                <th>Qty Target</th>
                <th>Target</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($proposal_item->result() as $data) { ?>
                <tr>
                    <td scope="row"><?= $no++ ?></td>
                    <td><?= $data->Barcode ?></td>
                    <td style="width:100%;"><?= $data->ItemName ?></td>
                    <td style="text-align: right;"><?= number_format($data->Price) ?></td>
                    <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                        <td style="text-align: right;"><?= $data->AvgSales ?></td>
                    <?php } ?>
                    <td style="text-align: right;"><?= number_format($data->Qty) ?></td>
                    <td style="text-align: right;"><?= number_format($data->Target) ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <?php
            $price = 0;
            $avg_sales = 0;
            $target = 0;
            $qty = 0;
            $costing = 0;
            foreach ($proposal_item->result() as $data) {
                $price += (float)$data->Price;
                $avg_sales += (float)$data->AvgSales;
                $target += (float)$data->Target;
                $qty += (float)$data->Qty;
                $costing += (float)$data->Costing;
            }
            ?>
            <tr>
                <td colspan="3">Total</td>
                <td style="text-align: right;">
                    <!-- <?= number_format($price); ?> -->
                </td>
                <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                    <td style="text-align: right;">
                        <?= number_format($avg_sales); ?>
                    </td>
                <?php } ?>
                <td style="text-align: right;">
                    <?= number_format($qty); ?>
                </td>
                <td style="text-align: right;">
                    <?= number_format($target); ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <!-- Begin Costing Product-->
    <div style="text-align:left; padding-top:10px;">
        <b style="font-size: 12px;">COSTING</b>
    </div>
    <table id="tb">
        <thead>
            <tr>
                <th>No.</th>
                <th>Description</th>
                <th>Price</th>
                <th>Qty Target</th>
                <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                    <th>Value</th>
                    <th>Promo(%)</th>
                <?php } ?>
                <?php if (activity_is_sales($proposal_header->row()->Activity) == 'N') { ?>
                    <th><?= getActivityName($proposal_header->row()->Activity) ?> Cost</th>
                <?php } ?>
                <th>Costing</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($proposal_item->result() as $data) { ?>
                <tr>
                    <td scope="row"><?= $no++ ?></td>
                    <td style="width:100%;"><?= $data->ItemName ?></td>
                    <td style="text-align: right;"><?= number_format($data->Price) ?></td>
                    <td style="text-align: right;"><?= $data->Qty ?></td>
                    <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                        <td style="text-align: right;"><?= number_format($data->PromoValue) ?></td>
                        <td style="text-align: right;"><?= $data->Promo ?></td>
                    <?php } ?>
                    <?php if (activity_is_sales($proposal_header->row()->Activity) == 'N') { ?>
                        <td><?= number_format($data->ListingCost) ?></td>
                    <?php } ?>
                    <td style="text-align: right;"><?= number_format($data->Costing) ?></td>
                </tr>
            <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td style="text-align: right;">
                    <!-- <?= number_format($price); ?> -->
                </td>
                <td style="text-align: right;">
                    <?= number_format($qty); ?>
                </td>
                <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                    <td></td>
                    <td></td>
                <?php } ?>
                <?php if (activity_is_sales($proposal_header->row()->Activity) == 'N') { ?>
                    <td></td>
                <?php } ?>
                <td style="text-align: right;">
                    <?= number_format($costing); ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <!-- End Costing Product -->


    <!-- Begin Costing Other-->
    <div style="text-align:left; padding-top:10px;">
        <b style="font-size: 12px;">COSTING</b>
    </div>
    <table id="tb">
        <thead>
            <tr>
                <th>No.</th>
                <th>Description</th>
                <th>Costing</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            $totalCostingOther = 0;
            foreach ($costing_other->result() as $data) {
                $totalCostingOther += $data->Costing;
            ?>
                <tr>
                    <td scope="row"><?= $no++ ?></td>
                    <td style="width:100%;"><?= $data->Desc ?></td>
                    <td style="text-align: right;"><?= number_format($data->Costing) ?></td>
                </tr>
            <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td style="text-align: right;">
                    <?= number_format($totalCostingOther); ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <!-- End Costing Other -->

    <div style="text-align:left; padding-top:10px;">
        <?php
        $allTotalCosting = $costing + $totalCostingOther;
        ?>
        <b style="font-size: 12px;">TOTAL COSTING : <?= number_format($allTotalCosting) ?></b>
    </div>

    <br>
    <div>
        <table>
            <?php
            if ($target != 0) {
                $cost_ratio = 0;
                $cost_ratio = ($allTotalCosting / $target) * 100;
            ?>
                <tr>
                    <td>COST RATIO</td>
                    <td>&nbsp;:&nbsp; <?= round($cost_ratio, 2) ?>%</td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <!-- PAGE 2 -->
    <div class="page-break"></div>

    <div>
        <!-- <img src="<?= base_url() ?>assets/dist/img/pandurasa_kharisma_pt.png" style="max-width:30px; padding-bottom:-10px;" alt=""> -->
        <span style="font-size:12px;"><b>DETAIL PROPOSAL <?= $proposal_header->row()->Number ?></b></span>
    </div>
    <div>
        <span style="font-size:12px; float: right; margin-top:-15px;"></span>
    </div>
    <hr>
    <table id="tb">
        <thead>
            <tr>
                <th style="width: fit-content;">No.</th>
                <th style="width: fit-content;">Customer Group</th>
                <th style="width: fit-content;">Barcode</th>
                <th>Item Name</th>
                <th style="width: fit-content">Sales</th>
                <th style="width: fit-content">Target</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($customer_item->result() as $data) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data->GroupName ?></td>
                    <td><?= $data->Barcode ?></td>
                    <td><?= $data->ItemName ?></td>
                    <td style="text-align: right;"><?= $data->Sales ?></td>
                    <td style="text-align: right;"><?= $data->Target ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php if ($customer->num_rows() < 10) { ?>
        <table id="tb">
            <thead>
                <tr>
                    <th style="width: fit-content;">No.</th>
                    <th style="width: fit-content;">Customer Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($customer->result() as $data) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data->CustomerName ?></td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    <?php } ?>

    <div>
        <!-- <table>
            <tr>
                <td>YTD Operating</td>
                <td>&nbsp;:&nbsp;<?= number_format($biaya->row()->YTD_operating) ?></td>
            </tr>
            <tr>
                <td>YTD Purchase</td>
                <td>&nbsp;:&nbsp;<?= number_format($biaya->row()->YTD_purchase) ?></td>
            </tr>
            <tr>
                <td>Unbooked</td>
                <td>&nbsp;:&nbsp;<?= number_format($Unbooked) ?></td>
            </tr>
            <tr>
                <td>A&P Booked</td>
                <td>&nbsp;:&nbsp;<?= number_format($AnpBooked) ?></td>
            </tr>
            <tr>
                <td>Balance</td>
                <td>&nbsp;:&nbsp;<?= number_format(round($biaya->row()->BalanceBudget)) ?></td>
            </tr>
        </table> -->
    </div>
    <div>
        <br>
        <table style="width:100%">
            <tr>
                <td>
                    Diajukan Oleh:
                </td>
                <?php
                if ($approved->num_rows() > 0) {
                    foreach ($approved->result() as $data) { ?>
                        <td>
                            Disetujui Oleh:
                        </td>
                    <?php }
                } else { ?>
                    <td>
                        Disetujui Oleh:
                    </td>
                    <td>
                        Disetujui Oleh:
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td><br><br><br></td>
                <?php
                if ($approved->num_rows() > 0) {
                    foreach ($approved->result() as $data) { ?>
                        <td>
                            <img src="<?= base_url() ?>assets/dist/img/pandurasa_kharisma_pt.png" style="max-width:30px; padding-bottom:-10px;" alt="">
                            <img src="<?= base_url() ?>assets/dist/img/approved.png" style="max-width:50px; padding-bottom:-10px;" alt="">
                        </td>
                    <?php }
                } else { ?>
                    <td><br><br><br></td>
                    <td><br><br><br></td>
                <?php } ?>
            </tr>
            <tr>
                <td><?= ucwords($proposal_header->row()->CreatedBy) ?></td>

                <?php
                if ($approved->num_rows() > 0) {
                    foreach ($approved->result() as $data) { ?>
                        <td><?= ucfirst($data->username) ?></td>
                    <?php }
                } else { ?>
                    <td>Management</td>
                    <td>Management</td>
                <?php } ?>
            </tr>
        </table>
    </div>

</body>

</html>