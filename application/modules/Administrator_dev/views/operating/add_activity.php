<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-2">
                        <h4><?=getActivityName($activity)?></h4>
                        <input type="hidden" class="act" value="<?=$activity?>">
                        <input onkeyup="calculate(this)" type="number" class="form-control pct">
                    </div>
                    <div class="col-md-10">
                        <button onclick="deleteForm(this)" class="btn btn-danger pull-right">Delete</button>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <?php foreach ($operating->result() as $data) { ?>
                                <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($operating->result() as $op) { ?>
                                <td>
                                    <input type="hidden" class="input_activity" value="<?=$activity?>">
                                    <input type="hidden" class="input_budget_code" value="<?=$budget_code.'/'.$activity?>">
                                    <input type="hidden" class="input_month" value="<?=$op->Month?>">
                                    <input type="hidden" class="input_operating" value="<?=$op->OperatingBudget?>">
                                    <input type="hidden" class="input_precentage">
                                    <input type="hidden" class="input_operating_activity">
                                    <span class="span_operating_activity"></span>
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>