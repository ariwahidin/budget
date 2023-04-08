<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body"">
                    <?php $data_budget = json_decode($data_budget); 
                        // var_dump($data_budget);
                    ?>
                    <button id="pilihBudget" class="btn btn-success pull-right">Pilih Budget</button>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-proses-simpan" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Budget</h4>
            </div>
            <div class="modal-header">
                <div class="col-md-8">
                <table>
                    <tr>
                        <td>Total Costing</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>
                            <input id="finalTotalCosting" type="text" class="form-control" readonly>
                            <input id="finalTotalCostingActual" type="text" class="form-control" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>Budget </td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>
                            <input id="finalBudgetTaked" type="text" class="form-control" readonly>
                        </td>
                    </tr>
                </table>
                </div>
                <div class="col-md-4">
                    <button id="buttonReset" class="btn btn-warning pull-right">Reset</button>
                    <button id="buttonSimpanFinal" class="btn btn-primary pull-right" style="margin-right:5px;">Simpan</button>
                </div>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-striped table_budget" id="table_budget">
                    <thead>
                        <tr>
                            <th>Code Anggaran</th>
                            <th>Brand</th>
                            <th>Activity</th>
                            <th>Year</th>
                            <th>Purchase Date</th>
                            <th>Budget</th>
                            <th>Actual Cost</th>
                            <th>Saldo Budget</th>
                            <th>Budget Used</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyTableBudget">
                        <?php foreach($data_budget as $data){ ?>
                            <tr>
                                <td>
                                    <?=$data->codeAnggaran?>
                                    <input id="budgetCode" type="text" class="form-control" value="<?=$data->budgetCode?>">
                                </td>
                                <td><?=getBrandName($data->brandCode)?></td>
                                <td><?=getActivityName($data->activity)?></td>
                                <td><?=$data->budgetYear?></td>
                                <td>
                                    <?php 
                                        $date = strtotime($data->month);
                                        $newFormat = date('M-Y',$date)
                                    ?>
                                    <?=$newFormat?>
                                </td>
                                <td id="tdBudgetValue"><?=$data->budgetAlocated?></td>
                                <td id="tdCost"></td>
                                <td id="tdSaldoBudget"></td>
                                <td id="tdBudgetUsed"></td>
                                <td>
                                    <button class="btn btn-primary btn-xs select_budget">Select</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <!-- <button id="submit" type="submit" class="btn btn-primary">Simpan</button> -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        $('#pilihBudget').on('click',function(){

            var inputTotalCosting = document.querySelector('input#grand_total_costing').value;
            var inputTotalBudget = document.querySelector('input#total_budget').value;
            var rowsCustomer = document.querySelectorAll('tbody#tbody_customer tr');
            // console.log(rowsCustomer.length);
            if(parseFloat(inputTotalCosting) > parseFloat(inputTotalBudget)){
                alert('Budget tidak mencukupi');
            }else if(rowsCustomer.length < 1){
                alert('Customer belum dipilih');
            }else{
                dataTableTableBudget();
                resetActualBudget();
                calculateTotalActualBudget();
            }

        });
            
        //evet push pilih budget (select)
        var buttonSelect = document.querySelector('table.table_budget');
        buttonSelect.addEventListener('click', function(e){
            var finalTotalCosting = document.querySelector('input#finalTotalCosting').value;
            var finalBudgetTaked = document.querySelector('input#finalBudgetTaked').value;
            if(parseFloat(finalTotalCosting) > parseFloat(finalBudgetTaked)){
                if(e.target.classList.contains('select_budget') == true){
                    e.target.disabled = true;
                    e.target.innerText = 'selected';
                    e.target.parentElement.parentElement.classList.add('selected');
                    var rows = e.target.parentElement.parentElement;
                    var inputCostingActual = document.querySelector('input#finalTotalCostingActual').value;
                    // console.log(rows);
                    rows.querySelector('td#tdCost').textContent = inputCostingActual;
                    var budgetTaked = rows.querySelector('td#tdBudgetValue').textContent;
                    var costingActual = parseFloat(inputCostingActual) - parseFloat(budgetTaked);
                    var saldoBudget = parseFloat(budgetTaked) - parseFloat(inputCostingActual);
                    var tdCost = rows.querySelector('td#tdCost').textContent;
                    var budgetUsed = parseFloat(budgetTaked) - parseFloat(tdCost);
                    if(budgetUsed < 0){
                        budgetUsed = budgetTaked;
                    }
                    // console.log(costingActual);
                    // console.log(saldoBudget);
                    // console.log(budgetUsed);
                    var tdSaldoBudget = rows.querySelector('td#tdSaldoBudget').textContent = saldoBudget; 
                    var tdBudgedUsed = rows.querySelector('td#tdBudgetUsed').textContent = budgetUsed;  
                    document.querySelector('input#finalTotalCostingActual').value = costingActual;
                    calculateTotalActualBudget()
                }
            }else{
                alert('Budget sudah mencukupi');
            }
            // console.log(finalTotalCosting);
            // console.log(finalBudgetTaked);
        });
        
        //event push reset
        buttonReset.addEventListener('click', function(){
            resetActualBudget();
            calculateTotalActualBudget()
        });

        //event simpan final
        var buttonSimpanFinal = document.querySelector('button#buttonSimpanFinal');
        buttonSimpanFinal.addEventListener('click', function(){

            var no_proposal = $('#no_proposal').val();
            var brand_code = $('#brand_code').val();
            var activity_code = $('#code_activity').val();
            var start_periode = $('#startPeriode').val() ;
            var end_periode = $('#endPeriode').val();

            var tableTargetFinal = document.querySelector('table#table_target');
            var rowsTableTargetFinal = tableTargetFinal.querySelectorAll('tr.rowTableTarget');

            var itemCode = [];
            var itemPrice = [];
            var quantityTarget = [];
            var targetValue = [];
            var promoValue = [];
            var promo = [];
            var costingValue = [];
            var dataItemTarget = {};

            for(var y = 0; y < rowsTableTargetFinal.length; y++){
                var inputItemCode = rowsTableTargetFinal[y].querySelector('input.itemCode').value;
                var inputItemPrice = rowsTableTargetFinal[y].querySelector('input.inputPrice').value;
                var inputQuantity = rowsTableTargetFinal[y].querySelector('input.inputTarget').value;
                var inputTargetValue = rowsTableTargetFinal[y].querySelector('input.inputTotalTarget').value;
                var inputPromoValue = rowsTableTargetFinal[y].querySelector('input.inputValuePromo').value;
                var inputPromo = rowsTableTargetFinal[y].querySelector('input.inputPromo').value;
                var inputCostingValue = rowsTableTargetFinal[y].querySelector('input.inputTotalCosting').value;

                itemCode.push(inputItemCode);
                itemPrice.push(inputItemPrice);
                quantityTarget.push(inputQuantity);
                targetValue.push(inputTargetValue);
                promoValue.push(inputPromoValue);
                promo.push(inputPromo);
                costingValue.push(inputCostingValue);
            }

            var inputTotalTarget = document.querySelector('input#subtotalTotalTarget').value;
            var inputTotalCosting = document.querySelector('input#subtotalTotalCosting').value;
            var cost_ratio = (parseFloat(inputTotalCosting) / parseFloat(inputTotalTarget))*100;

            //data item target
            dataItemTarget = {
                item_code : itemCode,
                item_price : itemPrice,
                quantity_target : quantityTarget,
                target_value : targetValue,
                promo_value : promoValue,
                promo : promo,
                costing_value : costingValue,
                cost_ratio : cost_ratio,
            };
            // console.log(dataItemTarget);

            var tableAddx = document.querySelector('table#tableAdd');
            var trAddx = tableAddx.querySelectorAll('tr.trAdd');

            var itemAdd = [];
            var quantityAdd = [];
            var priceAdd = [];
            var costAdd = [];
            var dataAdd = {};

            for(var a = 0; a < trAddx.length ; a++){
                var tdItemAdd = trAddx[a].querySelector('td.td_item').textContent;
                var tdQuantityAdd = trAddx[a].querySelector('td.td_quantity').textContent;
                var tdPriceAdd = trAddx[a].querySelector('td.td_price').textContent;
                var tdCostAdd = trAddx[a].querySelector('td.td_cost').textContent;

                itemAdd.push(tdItemAdd);
                quantityAdd.push(tdQuantityAdd);
                priceAdd.push(tdPriceAdd);
                costAdd.push(tdCostAdd);
            }

            //data item additioanal
            dataAdd = {
                item_add : itemAdd ,
                quantity_add : quantityAdd,
                price_add : priceAdd,
                cost_add : costAdd,
            };

            // console.log(dataAdd);

            var tableCustomer = document.querySelector('table#table_cust')
            var inputCodeCustomer = tableCustomer.querySelectorAll('input.code_customer');
            var customerCode = [];
            for(var i = 0 ; i < inputCodeCustomer.length ; i++){
                customerCode.push(inputCodeCustomer[i].value);
            }

            // Data budgeting
            var dataBudgeting = {};
            var tableBudget = document.querySelector('tbody#tbodyTableBudget');
            var trBudgetSelected = tableBudget.querySelectorAll('tr.selected');
            
            var budgetCode = [];
            var budgetValue = [];
            var cost = [];
            var saldoBudget = [];
            var budgetUsed = [];

            for(var i = 0; i < trBudgetSelected.length; i++){
                var inputBudgetCode = trBudgetSelected[i].querySelector('input#budgetCode').value;
                var tdBudgetValue = trBudgetSelected[i].querySelector('td#tdBudgetValue').textContent;
                var tdCost = trBudgetSelected[i].querySelector('td#tdCost').textContent;
                var tdSaldoBudget = trBudgetSelected[i].querySelector('td#tdSaldoBudget').textContent;
                var tdBudgetUsed = trBudgetSelected[i].querySelector('td#tdBudgetUsed').textContent;
                budgetCode.push(inputBudgetCode);
                budgetValue.push(tdBudgetValue);
                cost.push(tdCost);
                saldoBudget.push(tdSaldoBudget);
                budgetUsed.push(tdBudgetUsed);
            }

            dataBudgeting = {
                budgetCode,
                budgetValue,
                cost,
                saldoBudget,
                budgetUsed
            };

            console.log(dataBudgeting); 
            
            //data customer code
            // console.log(customerCode);

            $.ajax({
                url : '<?=site_url('ProposalPromosi_C/saveProposal')?>',
                type : 'POST',
                data : {
                    no_proposal,
                    brand_code,
                    activity_code,
                    start_periode,
                    end_periode,
                    unit : $('#unit').val(),
                    total_target : $('#subtotalTotalTarget').val(),
                    total_costing : $('#grand_total_costing').val(),
                    dataItemTarget,
                    dataAdd,
                    customerCode,
                    dataBudgeting,
                }
            });
        })


        function dataTableTableBudget(){
            $('#modal-proses-simpan').modal('show');
            var inputTotalCosting = document.querySelector('input#grand_total_costing').value;
            var inputTotalCostingFinal = document.querySelector('input#finalTotalCosting');

            var inputTotalCostingFinalActual = document.querySelector('input#finalTotalCostingActual');
            // inputTotalCostingFinal.value = 200000000;
            inputTotalCostingFinal.value = inputTotalCosting;
            inputTotalCostingFinalActual.value = inputTotalCostingFinal.value;

            setTimeout(function() {
                var dataTableBudget = $('#table_budget').dataTable({
                    searching: false,
                    paging: false,
                    ordering: false,
                    scrollY:300,
                });
            }, 500);
            $.fn.dataTable.ext.errMode = 'none'; //hapus error
        }

        function calculateTotalActualBudget(){
            var tableBudgetX = document.querySelector('#table_budget');
            var rowsSelected = tableBudgetX.querySelectorAll('tr.selected');
            var totalBudgetValue = 0;
            for(var x = 0; x < rowsSelected.length ; x++){
                var valueBudget = rowsSelected[x].querySelector('td#tdBudgetValue').textContent;
                totalBudgetValue += parseFloat(valueBudget);
            }
            document.querySelector('input#finalBudgetTaked').value = totalBudgetValue;
            // console.log(totalBudgetValue);
        }

        function resetActualBudget(){
            var buttonReset = document.querySelector('button#buttonReset');
            var tableBudget = document.querySelector('#table_budget');
            var buttonSelected = tableBudget.querySelectorAll('button.select_budget');
            for(var i = 0; i < buttonSelected.length; i++){
                buttonSelected[i].disabled = false;
                buttonSelected[i].innerText = 'select';
                if(buttonSelected[i].parentElement.parentElement.classList.contains('selected') == true){
                    buttonSelected[i].parentElement.parentElement.classList.remove('selected');
                    var rowsSelected = buttonSelected[i].parentElement.parentElement;
                    // console.log(rowsSelected);
                    rowsSelected.querySelector('td#tdCost').textContent = '';
                    rowsSelected.querySelector('td#tdSaldoBudget').textContent = '';
                    rowsSelected.querySelector('td#tdBudgetUsed').textContent = '';
                    var inputTotalCostingFinal = document.querySelector('input#finalTotalCosting');
                    var inputTotalCostingFinalActual = document.querySelector('input#finalTotalCostingActual');
                    inputTotalCostingFinalActual.value = inputTotalCostingFinal.value;
                }
            }
        }

    });
</script>