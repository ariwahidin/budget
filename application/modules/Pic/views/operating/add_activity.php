<div class="row row_activity">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <button onclick="deleteForm(this)" class="btn btn-danger pull-right">Delete</button>
                <table>
                    <tr>
                        <td>
                            <b><?= getActivityName($activity) ?>&nbsp;:&nbsp;</b>
                            <input type="hidden" class="act" value="<?= $activity ?>">
                        </td>
                        <td><input type="text" class="form-control inputPrecentagePeractivity" readonly style="max-width:60px"></td>
                        <td>&nbsp;<b>%</b>&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Value&nbsp;:&nbsp;</b></td>
                        <td><input type="text" class="form-control inputValuePerActivity" readonly></td>
                    </tr>
                </table>
            </div>
            <div class="box-body">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <?php foreach ($operating->result() as $data) { ?>
                                <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 0 !important;">
                                <input type="text" class="form-control" value="Percent(%)" readonly>
                                <input type="text" class="form-control" value="Value" readonly>
                            </td>
                            <?php
                            $no = 0;
                            foreach ($operating->result() as $op) { ?>
                                <td style="padding: 0 !important;">
                                    <input type="hidden" class="input_activity" value="<?= $activity ?>">
                                    <input type="hidden" class="input_budget_code" value="<?= $budget_code . '/' . $activity ?>">
                                    <input type="hidden" class="input_month" value="<?= $op->Month ?>">
                                    <input type="hidden" class="input_operating" value="<?= $op->OperatingBudget ?>">
                                    <input type="number" min="0" onkeypress="javascript:return isNumber(event)" class="form-control input_precentage" onkeyup="calculateFromPercent(this); calculate(this); calculateTotalUsedAllActivityPerMonth(); calculatePercent();">
                                    <input type="hidden" class="input_operating_activity">
                                    <input type="text" onkeypress="javascript:return isNumber(event)" onkeyup="calculate(this); formatNumber(this); calculateTotalUsedAllActivityPerMonth(); calculatePercent();" class="form-control input_operating_manual operating_<?= $no++ ?>" readonly>
                                    <input type="hidden" class="form-control input_percentage_permonth" readonly>
                                    <!-- <span class="span_operating_activity"></span> -->
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>