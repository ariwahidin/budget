<div class="modal fade" id="modal-create-on-top">
    <div class="modal-dialog" style="max-width: 450px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Create Budget On Top</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Month</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($month->result() as $data) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('M Y', strtotime($data->Month)) ?></td>
                                <td>
                                    <input type="number" class="form-control input-sm budget" data-month="<?= $data->Month ?>" value="0">
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
                <button onclick="createOnTop(this)" data-budget-code="<?= $budget_code ?>" type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>