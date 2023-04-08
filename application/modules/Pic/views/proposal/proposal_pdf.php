<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf; ?></title>
    <style>
        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
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
    <div style="text-align:center">
        <h3> Proposal Promotion </h3>
    </div>
    <div class="">
        <table>
            <tr>
                <td>No.</td>
                <td>&nbsp;:&nbsp;<?= $proposal_header->row()->Number ?></td>

            </tr>
            <tr>
                <td>Brand</td>
                <td>&nbsp;:&nbsp;<?= getBrandName($proposal_header->row()->BrandCode) ?></td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>&nbsp;:&nbsp;<?= date('d-M-Y', strtotime($proposal_header->row()->StartDatePeriode)) . ' to ' . date('d-M-Y', strtotime($proposal_header->row()->EndDatePeriode)) ?></td>
            </tr>
            <tr>
                <td>Pic</td>
                <td>&nbsp;:&nbsp;<?= ucfirst($proposal_header->row()->CreatedBy) ?></td>
            </tr>
            <tr>
                <td>Activity</td>
                <td>&nbsp;:&nbsp;<?= getActivityName($proposal_header->row()->Activity) ?></td>
            </tr>
            <tr>
                <td>Claim to</td>
                <td>&nbsp;:&nbsp;<?= ucfirst($proposal_header->row()->ClaimTo) ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>&nbsp;:&nbsp;<?= ucfirst($proposal_header->row()->Status) ?></td>
            </tr>
        </table>
    </div>
    <div>
        <table style="float:right">
            <tr>
                <td>Balance <?= getActivityName($proposal_header->row()->Activity) ?></td>
                <td>&nbsp;:&nbsp;<?= number_format(proposal_approved($proposal_header->row()->Number)->row()->Budget_balance) ?> (<?= proposal_approved($proposal_header->row()->Number)->row()->Budget_type ?>)</td>
            </tr>
        </table>
    </div>
    <div>
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
        <table>
            <tr>
                <th colspan="2">Promo Mechanism</th>
            </tr>
            <?php $no = 1;
            foreach ($mechanism->result() as $mek) { ?>
                <tr>
                    <td><?= $no++ ?>.</td>
                    <td><?= $mek->Mechanism ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div style="text-align:left">
        <b>Sales Target</b>
    </div>
    <table id="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Barcode</th>
                <th>Product Description</th>
                <th>Price</th>
                <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                    <th><?= $proposal_header->row()->AvgSales ?>(Qty)</th>
                <?php } ?>
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
                    <td><?= number_format($data->Price) ?></td>
                    <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                        <td><?= $data->AvgSales ?></td>
                    <?php } ?>
                    <td><?= number_format($data->Target) ?></td>
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
                <td>
                    <?= number_format($price); ?>
                </td>
                <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                    <td>
                        <?= number_format($avg_sales); ?>
                    </td>
                <?php } ?>
                <td>
                    <?= number_format($target); ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <div style="text-align:left">
        <b>Costing</b>
    </div>
    <table id="table">
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
                    <td><?= number_format($data->Price) ?></td>
                    <td><?= $data->Qty ?></td>
                    <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                        <td><?= number_format($data->Price * ($data->Promo / 100)) ?></td>
                        <td><?= $data->Promo ?></td>
                    <?php } ?>
                    <?php if (activity_is_sales($proposal_header->row()->Activity) == 'N') { ?>
                        <td><?= number_format($data->ListingCost) ?></td>
                    <?php } ?>
                    <td><?= number_format($data->Costing) ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td>
                    <?= number_format($price); ?>
                </td>
                <td>
                    <?= number_format($qty); ?>
                </td>
                <?php if (activity_is_sales($proposal_header->row()->Activity) != 'N') { ?>
                    <td></td>
                    <td></td>
                <?php } ?>
                <?php if (activity_is_sales($proposal_header->row()->Activity) == 'N') { ?>
                        <td></td>
                    <?php } ?>
                <td>
                    <?= number_format($costing); ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <div>
        <table>
            <?php
            $cost_ratio = 0;
            $cost_ratio = ($costing / $target) * 100;
            ?>
            <tr>
                <td>COST RATIO <span>(total costing/total target)</span></td>
                <td>&nbsp;:&nbsp; <?= round($cost_ratio) ?>%</td>
            </tr>
        </table>
    </div>
    <div>
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
                <td>
                    Diketahui Oleh:
                </td>
                <td>
                    Disetujui Oleh:
                </td>
                <td>
                    Update By:
                </td>
            </tr>
            <tr>
                <td><br><br><br></td>
                <td><br><br><br></td>
                <td><br><br><br></td>
                <td><br><br><br></td>
            </tr>
            <tr>
                <td><?= ucwords($proposal_header->row()->CreatedBy) ?></td>
                <td>
                    <?php if ($proposal_header->row()->Status == 'approved') { ?>
                        <?= ucwords($proposal_header->row()->ApprovedBy) ?>
                    <?php } ?>
                    <?php if ($proposal_header->row()->Status == 'cancelled') { ?>
                        <?= ucwords($proposal_header->row()->CancelBy) ?>
                    <?php } ?>
                </td>
                <td>Management</td>
                <td>Admin MKT</td>
            </tr>
        </table>
    </div>
</body>

</html>