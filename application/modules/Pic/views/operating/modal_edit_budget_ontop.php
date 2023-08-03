<div class="modal fade" id="modal-edit-on-top">
    <div class="modal-dialog" style="max-width: 250px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Edit Budget On Top</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Month</label>
                    <input type="text" class="form-control" value="<?= date('M Y', strtotime($budget->row()->month)) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="">Old Value</label>
                    <input type="number" class="form-control" id="old-on-top" value="<?= $budget->row()->budget_on_top ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="">New Value</label>
                    <input type="number" id="new-on-top" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
                <button onclick="editOnTop(this)" data-id="<?=$budget->row()->id?>" type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>