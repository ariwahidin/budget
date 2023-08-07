<div class="modal fade" id="modal-input-skp">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Input SKP</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <table class="table table-responsive table-bordered">
                        <?php foreach ($group->result() as $data) { ?>
                            <tr>
                                <td><?= $data->GroupName ?></td>
                                <td><input type="text" class="form-control" placeholder="Nomor SKP"></td>
                                <td><input type="text" class="form-control" placeholder="Keterangan"></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button onclick="simpanSKP(this)" data-number="<?= $number ?>" type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
    function simpanSKP(button) {
        let number = $(button).data('number')
        alert('test ' + number)
    }
</script>