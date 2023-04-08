<div class="modal fade" id="modal-set-new-budget-from-purchase" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                    // var_dump($_POST['myPeriodeDate']);
                    // var_dump(date('Y',strtotime($_POST['myPeriodeDate'][0]))); 
                ?>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Set New Budget From Purchase</h4>
            </div>
            <div class="modal-body">
            <div class="box-header">
                <div class="col-md-10">
                    <table>
                        <tr>
                            <td>Periode Budget</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?=$periode_budget?></td>
                        </tr>
                        <tr>
                            <td>Brand</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?=getBrandName($code_brand)?></td>
                        </tr>
                        <tr>
                            <td>Periode Purchase</td>
                            <td>&nbsp;:&nbsp;</td>
                            <?php 
                            $start = date('M-Y', strtotime($start_date)); 
                            $end = date('M-Y', strtotime($end_date)); 
                            ?>
                            <td> <?=$start.' s/d '.$end?></td>
                        </tr>
                        <tr>
                            <td>Set Budget (%)</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td>
                                <input id="budget_presentase" type="number" class="form-control">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-2">
                    <button id="set_activity" class="btn btn-primary pull-right">
                       <i class="fa fa-arrow-circle-right"></i> Set Activity
                    </button>
                </div>

            </div>
            <div class="box-body">
                <?php 
                    // var_dump($_POST);
                ?>
                <table class="table table-bordered table_purchase_">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Actual Purchase</th>
                            <th>Actual A&P Principal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($_POST['myPeriodeDate'] as $date){ ?>
                            <tr class="row_purchase">
                                <td><?=getBrandName($code_brand)?></td>
                                <td id="value_year"><?=date('Y',strtotime($date))?></td>
                                <td id="value_month"><?=date('M',strtotime($date))?></td>
                                <td id="value_amount"><?=number_format(getPurchase($code_brand, $date))?></td>
                                <td id="value_budget"></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function(e){
        $('#modal-set-new-budget-from-purchase').modal('show');
        calculate_budget_value();

        $('#set_activity').on('click', function(){
            loadSetActivityBudget()
        })
        
        function calculate_budget_value(){
            var budget_presentasion = $('#budget_presentase').val();
            $('#budget_presentase').on('keyup', function (){
                var row_purchase = $('.row_purchase');
                for( var i = 0; i < row_purchase.length ; i++){
                    var budget_presentasion = $('#budget_presentase').val();
                    var amount = row_purchase[i].querySelector('td#value_amount').textContent;
                    amount = amount.replace(/,/g, '');
                    var value_budget = row_purchase[i].querySelector('td#value_budget');
                    if(budget_presentasion != ''){
                        var value = (parseFloat(budget_presentasion)/100) * parseFloat(amount);
                        value = Math.round(value)
                        value = value.toLocaleString();
                        value_budget.textContent = value;
                    }else{
                        value_budget.textContent = '';
                    }
                }
            })
        }
    })

    function loadSetActivityBudget(){
        var code_brand = '<?=$code_brand?>';
        var periode_budget= '<?=$periode_budget?>';
        var start_date_purchase= '<?=$start_date?>';
        var end_date_purchase= '<?=$end_date?>';
        var presentase_budget = $('#budget_presentase').val();
        var budget_set = [];
        var date_periode = JSON.parse('<?= json_encode($_POST['myPeriodeDate'])?>')
        var table = document.querySelector('table.table_purchase_');
        var data_purchase_budget = table.querySelectorAll('tr.row_purchase');
        var purchase_amount = []

        for(var x = 0 ; x < data_purchase_budget.length; x++){
            var rowx = data_purchase_budget[x];
            var isiPurchaseAmount = rowx.querySelector('td#value_amount').textContent;
            purchase_amount.push(isiPurchaseAmount);
        }

        for(var i = 0; i < data_purchase_budget.length; i++){
            var rows = data_purchase_budget[i];
            var budget_setted = rows.querySelector('td#value_budget').textContent;
            budget_set.push(budget_setted);
        }

        if(presentase_budget > 100){
            alert('presentase tidak boleh lebih dari 100 %');
        }else{
            testFunction();
            $('#set_budget_activity').load('<?=site_url('Anggaran_C/showSetBudgetActivity')?>',{
                code_brand,
                periode_budget, 
                start_date_purchase, 
                end_date_purchase,
                presentase_budget,
                purchase_amount,
                budget_set,
                date_periode,
            });
            $('#modal-set-new-budget-from-purchase').modal('hide');
        }
    }

    function testFunction(){
        var element = document.querySelector('div#main-content');
        element.remove();
        // console.log(element);
    }
</script>