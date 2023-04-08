<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    Additional Target
                </h3>
            </div>
            <div class="box-body">
                <div class="form-group item_additional">
                    <div class="col-md-3">
                        <label for="">Description</label>
                        <input id="item" type="text" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="">Quantity</label>
                        <input id="quantity" type="number" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="">Price (Rp)</label>
                        <input id="price" type="number" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="">Cost (Rp)</label>
                        <input id="cost" type="number" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="">Action</label>
                        <br>
                        <button class="btn btn-success" id="add_item_additional">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <table id="tableAdd" class="table table-bordered" style="margin-top:20px; margin-left:15px;">
                            <thead>
                                <tr>
                                    <th style="width: 300px">Description</th>
                                    <th>Quantity</th>
                                    <th>Price (Rp)</th>
                                    <th>Cost (Rp)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="tbody_add">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><b>Total</b></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input id="total_item_add" type="number" class="form-control" readonly value="0">
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script type="text/javascript">

    
    calculateCostAdd();
    function calculateCostAdd(){
        var divAdd = document.querySelector('div.item_additional');
        var inputItemAdd = divAdd.querySelector('input#item');
        var inputQuantityAdd = divAdd.querySelector('input#quantity');
        var inputPriceAdd = divAdd.querySelector('input#price');
        var inputCost = divAdd.querySelector('input#cost');
        var valueInputCost = 0;

        inputQuantityAdd.addEventListener('keyup', function(){
            if(inputQuantityAdd.value != '' && inputPriceAdd.value != ''){
                valueInputCost = parseFloat(inputQuantityAdd.value) * parseFloat(inputPriceAdd.value);
                inputCost.value = valueInputCost;
            }
        });

        inputPriceAdd.addEventListener('keyup', function(){ 
            if(inputQuantityAdd.value != '' && inputPriceAdd.value != ''){
                valueInputCost = parseFloat(inputQuantityAdd.value) * parseFloat(inputPriceAdd.value);
                inputCost.value = valueInputCost;
            }
        });

    }



    var button_add = document.querySelector('button#add_item_additional');
    button_add.addEventListener('click', function(){
        add_item_additional();
        calculate_grand_total_costing();
    })
    
    document.querySelector('tbody.tbody_add').addEventListener('click', function(e){
        //delete row
        if(e.target.classList.contains('delete_item_add') == true ){
            e.target.parentElement.parentElement.remove();
            calculate_total_item_additional();
            calculate_grand_total_costing()
        }
    })
    
    
    function add_item_additional(){
        var table = document.querySelector('tbody.tbody_add');
        var item_add = document.querySelector('div.item_additional');
        var item = item_add.querySelector('#item'); 
        var target_quantity = item_add.querySelector('input#quantity'); 
        var target_price = item_add.querySelector('input#price'); 
        var target_cost = item_add.querySelector('input#cost');


        var tr_add = document.createElement('tr');
        var td_item = document.createElement('td');
        var td_target_quantity = document.createElement('td');
        var td_target_price = document.createElement('td');
        var td_target_cost = document.createElement('td');
        var td_button = document.createElement('td');
        var button_delete = document.createElement('button');
        tr_add.classList.add('trAdd');
        td_item.className = 'td_item';
        td_target_quantity.className = 'td_quantity';
        td_target_price.className = 'td_price';
        td_target_cost.className = 'td_cost';
        button_delete.classList.add('btn', 'btn-sm', 'btn-danger', 'delete_item_add');
        button_delete.textContent = 'Delete';


        td_item.textContent = item.value;
        td_target_quantity.textContent = target_quantity.value;
        td_target_price.textContent = target_price.value;
        td_target_cost.textContent = target_cost.value;

        if(item.value != '' && target_quantity.value != '' && target_price.value != '' && target_cost.value != ''){
            td_button.appendChild(button_delete);
            tr_add.appendChild(td_item);
            tr_add.appendChild(td_target_quantity);
            tr_add.appendChild(td_target_price);
            tr_add.appendChild(td_target_cost);
            tr_add.appendChild(td_button);
            table.appendChild(tr_add);
            item.value = '';
            target_quantity.value = '';
            target_price.value = '';
            target_cost.value = '';
            calculate_total_item_additional();
        }
    }

    function calculate_total_item_additional(){
        var total_target_cost = 0;
        var classTotalCost = document.querySelectorAll('td.td_cost');

        for(var i = 0; i < classTotalCost.length ; i++){
            total_target_cost += parseFloat(classTotalCost[i].textContent); 
        }

        var input_total_cost = document.getElementById('total_item_add');
        input_total_cost.value = total_target_cost;
    }
</script>