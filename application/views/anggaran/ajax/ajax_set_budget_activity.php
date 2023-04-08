<?php 
    // var_dump($data);
?>
<style>
    input.budgetMonthValue {
        width : 120px !important;
    }
</style>
<section class="content-header">
    <h1>
    Set Activity Budget
    </h1>
    <br>
</section>
<section class="content-body">
    <div class="box">
        <div class="box-header">
            <div class="col-md-6">
                <table>
                    <tr>
                        <td>Brand</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=getBrandName($data['code_brand'])?></td>
                    </tr>
                    <tr>
                        <td>Periode Purchase</td>
                        <td>&nbsp;:&nbsp;</td>
                        <?php 
                            $start = date('M-Y', strtotime($data['start_date_purchase'])); 
                            $end = date('M-Y', strtotime($data['end_date_purchase'])); 
                        ?>
                        <td><?=$start.' s/d '.$end?></td>
                    </tr>
                    <tr>
                        <td>Budget</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=$data['periode_budget']?></td>
                    </tr>
                    <tr>
                        <td>Total Purchase</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=number_format($total_purchase)?></td>
                    </tr>
                    <tr>
                        <td>Total Anp (<?=$data['presentase_budget']?>%)</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=number_format($total_anp)?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <button id="simpanBudget" class="btn btn-primary pull-right">Simpan</button>
            </div>
        </div>
        <div class="box-body">
            <?php 
                // var_dump($_POST);
            ?>
            <table class="table table-bordered table_set_budget table-responsive" >
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Presentase <br>
                            <b id="totalPresentase"></b><b>&nbsp;%</b>
                        </th>
                        <?php foreach($data['date_periode'] as $k => $v){
                            $s = new DateTime($v);
                            $date = $s->format('M-Y');
                            echo "<th>".$date."</th>";
                        } ?>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <?php foreach($data['budget_set'] as $dx){
                            echo "<th>".$dx."</th>";
                        } ?>
                    </tr>
                </thead>
                <tbody id="tbodyBudgetSet">
                    <?php foreach($activity->result() as $v){ ?>
                        <tr>
                            <td>
                                <?=$v->promo_name?>
                                <input type="hidden" class="form-control idActivity" value="<?=$v->id?>" readonly>
                            </td>
                            <td>
                                <input class="input_presentase form-control" type="number">
                            </td>
                            <?php foreach($data['date_periode'] as $key => $d){ ?>
                                <td>
                                    <input class="budgetTotal form-control" type="hidden" value="<?=$data['budget_set'][$key]?>" readonly>
                                    <input class="budgetMonth form-control" type="hidden" value="<?=$d?>" readonly>
                                    <input class="budgetYear form-control" type="hidden" value="<?=$d?>" readonly>
                                    <input class="budgetMonthValue form-control" type="text" readonly>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>

    $(document).ready(function(){
        var body = document.querySelector('body');
        $('.table_set_budget').dataTable({
            paging: false,
            scrollY: 400,
            scrollX: true,
            responsive: true,
            searching: false,
        });

        $('input.input_presentase').on('keyup', function(e){
            calculateBudgetValue(e);
            calculateTotalPresentase();
        });

        function calculateTotalPresentase(){
            var inputTotalPresentase = document.getElementById('totalPresentase');
            var inputPresentase = document.querySelectorAll('input.input_presentase');
            var valueTotalPresentase = 0;
            for(var i = 0 ; i < inputPresentase.length ; i++){
                if(inputPresentase[i].value != ''){
                    valueTotalPresentase += parseFloat(inputPresentase[i].value);
                }
            }
            // console.log(valueTotalPresentase);
            inputTotalPresentase.textContent = valueTotalPresentase;
        }

        function calculateBudgetValue(e){
            var presentase = e.target.value;
            var rows = e.target.parentElement.parentElement;
            var budgetTotal = rows.querySelectorAll('input.budgetTotal');
            var budgetPerMonth = rows.querySelectorAll('input.budgetMonthValue');
            var valueBudget = 0;
            for(var i = 0 ; i < budgetTotal.length ; i++){
                if(presentase != 0){
                    var budget = budgetTotal[i].value;
                    budget = budget.replace(/,/g, '');
                    valueBudget = (parseFloat(presentase)/100) * parseFloat(budget);
                    valueBudget = Math.round(valueBudget);
                    valueBudget = valueBudget.toLocaleString();
                    budgetPerMonth[i].value = valueBudget;
                }else{
                    budgetPerMonth[i].value = '';
                }
            }
        }

        $('#simpanBudget').on('click', function(){ 
            var table = document.querySelector('tbody#tbodyBudgetSet');
            var rowsBudget = table.querySelectorAll('tr'); 
            var budgetValue = [];
            var year = [];
            var monthValue = []; 
            var monthBudget = []; 
            var presentase = [];
            var activity = [];
            for(var i = 0 ; i < rowsBudget.length ; i++){
                var presentaseInput = rowsBudget[i].querySelector('input.input_presentase').value;
                var activityInput = rowsBudget[i].querySelector('input.idActivity').value;
                if(presentaseInput != ''){
                    var monthBudgetInput = rowsBudget[i].querySelectorAll('input.budgetTotal');
                    var budgetValueInput = rowsBudget[i].querySelectorAll('input.budgetMonthValue');
                    var yearInput = rowsBudget[i].querySelectorAll('input.budgetYear');
                    var monthInput = rowsBudget[i].querySelectorAll('input.budgetMonth ');
                    var monthBudgetIsi = [];
                    var budgetValueIsi = [];
                    var yearIsi = [];
                    var monthIsi = [];
                    for(var u = 0 ; u < budgetValueInput.length ; u++){
                        monthBudgetIsi.push(monthBudgetInput[u].value);
                        budgetValueIsi.push(budgetValueInput[u].value);
                        yearIsi.push(yearInput[u].value);
                        monthIsi.push(monthInput[u].value);
                    }
                    monthBudget.push(monthBudgetIsi);
                    budgetValue.push(budgetValueIsi);
                    year.push(yearIsi);
                    monthValue.push(monthIsi);
                    presentase.push(presentaseInput);
                    activity.push(activityInput);
                }
            }
               var amountPurchase = JSON.parse('<?=json_encode($data['purchase_amount'])?>'); 
            // console.log(dataPurchase);
            // var monthPurchase = [];
            // var amountPurchase = [];
            // for(var i = 0; i < dataPurchase.length; i++){
            //     monthPurchase.push(dataPurchase[i].Month);
            //     amountPurchase.push(dataPurchase[i].Amount);
            // }
            var brandCode = '<?=$_POST['code_brand']?>';
            var purchasePresentase = '<?=$_POST['presentase_budget']?>';
            var periodeStart = '<?=$_POST['start_date_purchase']?>';
            var periodeEnd = '<?=$_POST['end_date_purchase']?>';
            var budgetYearPeriode = '<?=$_POST['periode_budget']?>';
            // console.log(monthPurchase);
            // console.log(amountPurchase);
            // console.log(activity);
            // console.log(presentase);
            // console.log(budgetValue);
            // console.log(year);
            // console.log(monthValue);
            var inputTotalPresentase = document.getElementById('totalPresentase');
            if(inputTotalPresentase.textContent > 100){
                alert('Presentase tidak boleh lebih dari 100 %');
            } else if (inputTotalPresentase.textContent < 100) {
                alert('Presentase tidak boleh kurang dari 100 %')
            } else {
                $.ajax({
                    url : '<?=site_url('Anggaran_C/simpanAnggaran')?>',
                    type : 'POST',
                    data : {
                        brandCode,
                        budgetYearPeriode,
                        periodeStart,
                        periodeEnd,
                        purchasePresentase,
                        activity,
                        monthBudget,
                        presentase,
                        budgetValue,
                        year,
                        monthValue,
                        amountPurchase,
                    },
                    dataType : 'JSON',
                    success : function(response){
                        if(response.success == true){
                            alert('Data berhasil disimpan');
                            window.location.href = '<?=site_url('anggaran')?>';
                        }
                    }
                })
            }
        })
    })
</script>