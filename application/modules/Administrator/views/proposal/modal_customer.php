<div class="modal fade" id="modal_customer" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Customer</h4>
            </div>
            <div class="modal-body">
                <form id="frm-example" name="frm-example">
                    <table class="table table-bordered table-striped" id="table_customer">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Card Code</th>
                                <th>Group Name</th>
                                <th>Customer Name</th>
                            </tr>
                        </thead>
                        <tbody class="tbody_customer">
                            <?php if ($customer->num_rows() > 0) { ?>
                                <?php foreach ($customer->result() as $data) { ?>
                                    <tr>
                                        <td class="CustomerCode">
                                            <?= $data->CardCode . ';' . $data->GroupName . ';' . str_replace(',','',$data->CustomerName) ?>
                                        </td>
                                        <td class="CardCode"><?= $data->CardCode ?></td>
                                        <td class="GroupName"><?= $data->GroupName ?></td>
                                        <td class="CustomerName"><?= str_replace(',','',$data->CustomerName) ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                Tidak Ada Data
                            <?php } ?>
                        </tbody>
                    </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="button_add_customer" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#modal_customer').modal('show');

        var table_customer = $('#table_customer').DataTable({
            'columnDefs': [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            'select': {
                'style': 'multi'
            },
            'order': [
                [1, 'asc']
            ]
        });

        $('#button_add_customer').on('click', function() {
            var customer_code = []
            var selected_customer = table_customer.column(0).checkboxes.selected().join();
            customer_code = selected_customer.split(',');
            // console.log(customer_code);
            var tbodyCustomer = document.getElementById('tbodyCustomer');

            if (selected_customer != '') {
                for (var i = 0; i < customer_code.length; i++) {
                    var tr = document.createElement('tr');
                    var tdCustomerCode = document.createElement('td');
                    var tdGroupName = document.createElement('td');
                    var tdCustomerName = document.createElement('td');
                    var tdAction = document.createElement('td');

                    tdCustomerCode.className = 'CustomerCode_Customer';
                    tdGroupName.className = 'GroupName_Customer';
                    tdCustomerName.className = 'CustomerName_Customer';
                    tdAction.innerHTML = '<button onclick="deleteRowCustomer(this)" class="btn btn-danger btn-xs">Delete</button>';

                    tdCustomerCode.innerText = customer_code[i].split(";")[0];
                    tdGroupName.innerText = customer_code[i].split(";")[1];
                    tdCustomerName.innerText = customer_code[i].split(";")[2];

                    tr.appendChild(tdCustomerCode);
                    tr.appendChild(tdGroupName);
                    tr.appendChild(tdCustomerName);
                    tr.appendChild(tdAction);
                    tbodyCustomer.appendChild(tr);
                }
            }
            $('#modal_customer').modal('hide');
        });
    })
</script>