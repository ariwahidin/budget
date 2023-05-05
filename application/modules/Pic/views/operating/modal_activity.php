<div class="modal flip" id="modal_pilih_activity" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="table_activity_modal">
                    <thead>
                        <tr>
                            <th>Activity Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activity->result() as $ac) { ?>
                            <tr>
                                <td><?= $ac->promo_name ?></td>
                                <td>
                                    <button onClick="addFormActivity(this)" data-activity_code="<?= $ac->id ?>" data-budget_code="<?= $budget_code ?>"  class="btn btn-primary btn-xs">Select</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btn_set_promo" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#table_activity_modal').DataTable();
        $('#modal_pilih_activity').modal('show');
    });
</script>