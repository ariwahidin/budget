<div class="modal fade" id="modal_set_promo" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Set Promo : <b id="md_item_name">Item Name</b>/<b id="md_barcode">Barcode</b></h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="table_customer">
                    <thead>
                        <tr>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Target</th>
                            <th>Promo</th>
                            <th>Total Costing</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input id="md_price" type="text" class="form-control">
                            </td>
                            <td>
                                <input id="md_qty" type="text" class="form-control">
                            </td>
                            <td>
                                <input id="md_target" type="text" class="form-control">
                            </td>
                            <td>
                                <input id="md_promo" type="text" class="form-control">
                            </td>
                            <td>
                                <input id="md_costing" type="text" class="form-control">
                            </td>
                        </tr>
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
    $(document).ready(function() {
        $('#btn_set_promo').on('click', function() {
            var id =document.getElementById('md_barcode').innerText;
            var dest = document.getElementById(id).parentElement;
            console.log(id);
            console.log(dest);
            dest.querySelector('td.price_item').innerText = $('#md_price').val();
            $('#modal_set_promo').modal('hide');
        });
    })
</script>