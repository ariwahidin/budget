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
                        <?php foreach($customer as $cust => $value) { ?>
                            <tr>
                                <td>
                                    <?=$value->CardCode?>
                                </td>
                                <td><?=$value->GroupName?></td>
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
            myArr = [];

            var customerName = [];
            var rows_customer = table.column(0).checkboxes.selected().join();
            // console.log(table);

            var rows_selected = table.column(0).checkboxes.selected().join();
            myArr = rows_selected.split(',');
            var code_customer = myArr;
            for(var i = 0; i < code_customer.length; i++){  
                
                var tbody_customer = document.getElementById("tbody_customer");
                var tr = document.createElement("tr");
                var td1 = document.createElement("td");
                var td2 = document.createElement("td");
                var button = document.createElement("button");
                var input = document.createElement("input");
                
                input.classList.add('code_customer');
                input.value = code_customer[i];
                input.setAttribute('type', 'hidden');
                button.classList.add('btn','btn-xs','btn-danger', 'hapus_budget');
                button.setAttribute('onClick', 'deleteRow(this)');
                button.textContent = "delete";
                td2.classList.add('text-center');

                // console.log(code_customer[i]);
                td1.textContent = getCustomerName(code_customer[i]);
                td1.appendChild(input);
                td2.appendChild(button); 
                tr.appendChild(td1);
                tr.appendChild(td2);
                tbody_customer.appendChild(tr);
            }
            $('#modal-customer').modal('hide');
        });
    })

    function deleteRow(r) {
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("table_cust").deleteRow(i);
    }

    function getCustomerName(c){
        var jqXHR = $.ajax({
            url : '<?=site_url('customer/getCustomerName')?>',
            type : 'POST',
            async: false,
            data : {
                code : c,
            },
        });
        return JSON.parse(jqXHR.responseText);
    }
</script>