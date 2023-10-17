<div class="box box-primary">
    <div class="box-header">
        <b>On Top</b>
        <?php if ($budget->num_rows() < 1) { ?>
            <button onclick="loadModalCreateOnTop(this)" data-budget-code="<?= $budget_code ?>" class="btn btn-primary btn-xs pull-right">
                Create Budget On Top
            </button>
        <?php } ?>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped" style="font-size: 11px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Month</th>
                    <th>Value</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($budget->result() as $data) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('M Y', strtotime($data->month)) ?></td>
                        <td><?= number_format($data->budget_on_top) ?></td>
                        <!-- <td>
                            <button onclick="loadModalEditOnTop(this)" data-id="<?= $data->id ?>" class="btn btn-primary btn-xs">Edit</button>
                        </td> -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>