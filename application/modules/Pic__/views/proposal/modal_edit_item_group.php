<div class="modal fade" id="modal_edit_item" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Edit Item</strong>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>Group Customer</th>
                            <th>Item Name</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <?php var_dump($item->result()) ?> -->
                        <tr>
                            <td>
                                <?= $item->row()->GroupName ?>
                            </td>
                            <td>
                                <?= $item->row()->ItemName ?>
                            </td>
                            <td>
                                <input type="number" id="input_edit_qty" class="form-control" value="<?= $item->row()->Target ?>">
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="editItemExecute(this)" data-id="<?= $item->row()->id ?>" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#modal_edit_item').modal('show')

    function editItemExecute(button) {
        let qty = $('#input_edit_qty').val()
        let id = $(button).data('id')
        if (qty.trim() != "") {
            $.ajax({
                url: "<?= base_url($_SESSION['page']) ?>/editItemExecute",
                method: "POST",
                data: {
                    id,
                    qty
                },
                dataType: "JSON",
                success: function(response) {

                }
            })
        }
    }
</script>