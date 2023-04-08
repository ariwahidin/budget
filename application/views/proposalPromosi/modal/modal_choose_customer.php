<div class="modal fade" id="modal-customer">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Customer</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="table_customer">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Group</th>
                            <th>Customer Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; ?>
                        <?php foreach($customer->result() as $cust => $value) { ?>
                            <tr>
                                <td>
                                    <?=$value->CardCode?>
                                </td>
                                <td><?=$value->GroupCode?></td>
                                <td><?=$value->CustomerName?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="submit_customer" type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#modal-customer').modal('show')

        var table = $('#table_customer').DataTable({
            'columnDefs': [
                {
                    'targets': 0,
                    'checkboxes': {
                    'selectRow': true
                    }
                }
            ],
            'select': {
                'style': 'multi'
            },
            'order': [[1, 'asc']]
        });

        $('#submit_customer').on('click', function(e){
            getCustomerData();
        });

        function getCustomerData(){
            var rows_selected = table.column(0).checkboxes.selected().join();
            var customer_code = rows_selected.split(',');
            $.ajax({
                url : '<?=site_url('ProposalPromosi_C/getCustomerSelected')?>',
                type : 'POST',
                data : {
                    customer_code,
                },
                dataType : 'JSON',
                success : function(response){
                    addCustomer(response);
                }
            });
        }

        function addCustomer(data){
            for(var i = 0; i < data.length; i++){  
                var tbody_customer = document.getElementById("tbody_customer");
                var tr = document.createElement("tr");
                var tdGroupCustomer = document.createElement("td");
                var tdCustomerName = document.createElement("td");
                var tdAction = document.createElement("td");
                var buttonDelete = document.createElement("button");
                var inputCustomerCode = document.createElement("input");
                inputCustomerCode.classList.add('code_customer');
                inputCustomerCode.value = data[i].CardCode;
                inputCustomerCode.setAttribute('type', 'hidden');
                buttonDelete.classList.add('btn','btn-xs','btn-danger', 'hapus_budget');
                buttonDelete.setAttribute('onClick', 'deleteRow(this)');
                buttonDelete.textContent = "delete";
                tdAction.classList.add('text-center');
                tdGroupCustomer.textContent = data[i].GroupCode;
                tdCustomerName.textContent = data[i].CustomerName;
                tdCustomerName.appendChild(inputCustomerCode);
                tdAction.appendChild(buttonDelete); 
                tr.appendChild(tdGroupCustomer);
                tr.appendChild(tdCustomerName);
                tr.appendChild(tdAction);
                tbody_customer.appendChild(tr);
            }
            $('#modal-customer').modal('hide');
        }

    })

    function deleteRow(r) {
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("table_cust").deleteRow(i);
    }
</script>