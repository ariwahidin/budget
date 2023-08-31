<div class="modal fade" id="modal-customer">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Customer Detail</h4>
            </div>
            <div class="modal-body">
                <table style="font-size: 12px;" class="table table-bordered table-striped" id="tableCustomer">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service By</th>
                            <th>Group Customer</th>
                            <th>Customer Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($customer->result() as $data) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->ServiceBy ?></td>
                                <td><?= $data->GroupCustomer ?></td>
                                <td><?= $data->CardName ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tableCustomer').DataTable()
    })
</script>