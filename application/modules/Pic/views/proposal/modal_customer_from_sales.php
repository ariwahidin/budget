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
                                            <?= $data->CardCode ?>
                                        </td>
                                        <td class="CardCode"><?= $data->CardCode ?></td>
                                        <td class="GroupName"><?= $data->GroupName ?></td>
                                        <td class="CustomerName"><?= str_replace(',', '', $data->CustomerName) ?></td>
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
        loadingHide();

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
            var tbodyCustomer = document.getElementById('tbodyCustomer');
            // console.log(customer_code);
            // console.log(customer_code.length);
            // return false
            loadingShow()
            $.ajax({
                url: "<?= base_url($_SESSION['page']) . '/getCustomer' ?>",
                type: "POST",
                data: {
                    customer_code : JSON.stringify(customer_code)
                },
                dataType: "JSON",
                success: function(response) {
                    // console.log(response.customer.length)
                    // console.log(response.customer)

                    if (response.customer.length > 0) {
                        for (var i = 0; i < response.customer.length; i++) {
                            var tr = document.createElement('tr');
                            tr.setAttribute('data-tr-group-code', response.customer[i].GroupCode);
                            var tdCustomerCode = document.createElement('td');
                            var tdGroupName = document.createElement('td');
                            var tdCustomerName = document.createElement('td');
                            var tdAction = document.createElement('td');

                            var input_customer = document.createElement('input');
                            input_customer.setAttribute('type', 'hidden');
                            input_customer.classList.add('input_customer');
                            // input_customer.name = 'customer[]';
                            input_customer.value = response.customer[i].CardCode;
                            var input_group = document.createElement('input');
                            input_group.setAttribute('type', 'hidden');
                            input_group.classList.add('input_group');
                            // input_group.name = 'group[]';
                            input_group.value = response.customer[i].GroupCode;

                            tdCustomerCode.className = 'CustomerCode_Customer';
                            tdGroupName.className = 'GroupName_Customer';
                            tdCustomerName.className = 'CustomerName_Customer';
                            tdAction.innerHTML = '<button onclick="deleteRowCustomer(this)" class="btn btn-danger btn-xs">Delete</button>';

                            tdCustomerCode.innerText = response.customer[i].CardCode;
                            tdGroupName.innerText = response.customer[i].GroupName;
                            tdCustomerName.innerText = response.customer[i].CustomerName;

                            tdCustomerCode.appendChild(input_customer);
                            tdCustomerCode.appendChild(input_group);

                            tr.appendChild(tdCustomerCode);
                            tr.appendChild(tdGroupName);
                            tr.appendChild(tdCustomerName);
                            tr.appendChild(tdAction);
                            tbodyCustomer.appendChild(tr);
                        }
                        // console.log(tbodyCustomer);
                        $('#modal_customer').modal('hide');
                        loadingHide()
                    } else {
                        //alert('Tidak Ada Data');
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: 'Data is not found',
                            // footer: '<a href="">Why do I have this issue?</a>'
                        })
                    }

                }
            })
        });
    })
</script>