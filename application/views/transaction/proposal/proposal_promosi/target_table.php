<div class="row">
    <div class="col-md-12">
        
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <button type="button" class="btn btn-success" id="btn_get_item">Pilih Item</button>
            </div>
            <div class="box-body">
                <table id="table_target" class="table table-bordered table_target">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Barcode</th>
                            <th>Price</th>
                            <!-- <th>Sales</th> -->
                            <th>Target</th>
                            <th>Total Target</th>
                            <th>Promo (%)</th>  
                            <th>Total Costing</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_target">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><b>Total</b></td>
                            <td></td>
                            <td></td>
                            <!-- <td></td> -->
                            <td></td>
                            <td>
                                <input id="subtotalTotalTarget" type="number" class="form-control" readonly="readonly">
                            </td>
                            <td></td>
                            <td>
                                <input id="subtotalTotalCosting" type="number" class="form-control" readonly="readonly">
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="show_modal_item"></div>
</div>  
<script type="text/javascript">
    $(document).ready(function(){
        $('#btn_get_item').on('click', function(){
            const code_brand = $('#brand_code').val();
            const item_code = [];
            const classItemCode = $('.itemCode');
            for( let i = 0; i < classItemCode.length ; i++){
                item_code.push(classItemCode[i].value);
            }
            // console.log(item_code);
            $('#show_modal_item').load('<?=site_url('ProposalPromosi_C/get_item_for_modal_choose_item')?>', {code_brand: code_brand, item_code: item_code});
        })
    })

    //Delete row (biasakan gunakan seperti ini)
    const tableTarget = document.querySelector('.table_target');
    tableTarget.addEventListener('click', function(e){
        if(e.target.classList.contains('buttonDeleteRow') == true ){
            e.target.parentElement.parentElement.remove();
        }
        calculateSubtotalTotalTargetAndSubtotalTotalCosting();
    });

    tableTarget.addEventListener('keyup', function(e){
        const row = e.target.parentElement.parentElement;
        const inputPrice = row.querySelector('input.inputPrice').value;
        // const inputSales = row.querySelector('input.inputSales').value;
        const inputTarget = row.querySelector('input.inputTarget').value;
        const totalTarget = parseFloat(inputTarget) * parseFloat(inputPrice);
        const inputTotalTarget = row.querySelector('input.inputTotalTarget').value = isNaN(totalTarget) ? '' : totalTarget;
        const inputPromo = row.querySelector('input.inputPromo').value;
        const totalCosting = (parseFloat(inputPromo)/100) * inputTotalTarget;
        const inputTotalCosting = row.querySelector('input.inputTotalCosting').value = isNaN(totalCosting) ? '' : totalCosting;

        calculateSubtotalTotalTargetAndSubtotalTotalCosting();
    })

    function calculateSubtotalTotalTargetAndSubtotalTotalCosting(){
        const columnTotalTarget = document.getElementsByClassName('inputTotalTarget');
        const columnTotalCosting = document.getElementsByClassName('inputTotalCosting');
        var subtotalTotalTarget = 0;
        for (let i = 0; i < columnTotalTarget.length ; i++){
            var totalTargetTemp = parseFloat(columnTotalTarget[i].value);
            if(!isNaN(totalTargetTemp)){
                subtotalTotalTarget += totalTargetTemp;
            }
        }
        document.querySelector('table.table_target input#subtotalTotalTarget').value = subtotalTotalTarget;
        var subtotalTotalCosting = 0;
        for (let i = 0; i < columnTotalCosting.length ; i++){
            var totalCostingTemp = parseFloat(columnTotalCosting[i].value);
            if(!isNaN(totalCostingTemp)){
                subtotalTotalCosting += totalCostingTemp;
            }
        }
        document.querySelector('table.table_target tfoot input#subtotalTotalCosting').value = subtotalTotalCosting;
    }
</script>