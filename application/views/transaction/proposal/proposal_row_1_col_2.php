<div class="box box-widget">
    <!-- <div class="box-header">
        <h4>Table Budget</b></h4>
    </div> -->
    <div class="box-body">
        <table id="table_budget_used" class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Budget</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="tbody_budget">
            
            </tbody>
        </table>
    </div>
    <div class="box-footer">
        <button id="get_budget" class="btn btn-primary pull-right">
            <i class="fa fa-plus"></i> Pilih Budget
        </button>
    </div>
</div><br>
<div class="box box-widget">
    <div class="box-body">
        <table class="table table-responsive">
            <tr>
                <td>
                    <h4><b>Subtotal</b></h4>
                </td>
                <td>
                    <input id="total_costing" type="text" class="form-control" value="<?=$sum_costing?>" readonly>
                </td>
            </tr>
        </table>
    </div>
</div>

<div id="muncul_modal_customer"></div>
<div id="muncul_modal_budget"></div>
<script>

    $(document).on('click','#tampil_modal_customer', function(){
        var from_sales = '<?=$from_sales?>';
        var code_customer = [];
        var cdCust = $('.code_customer');
        for(var i = 0; i < cdCust.length ; i++){
            code_customer.push(cdCust[i].value);
        }
        $('#muncul_modal_customer').load('<?=site_url('proposal/get_customer_modal')?>',{code_customer:code_customer, from_sales:from_sales});
    })

    $(document).on('click','#get_budget', function(){
        var activity = '<?=$activity?>';
        var tahun = '<?=substr($start_date,6,4)?>';
        var code_brand = '<?=$code_brand?>';
        var months = document.getElementsByClassName("monthUsed");
        var month = [];
        for(var i = 0; i<months.length; i++){
            month.push(months[i].value);
        }
        // console.log(month); 

        $('#muncul_modal_budget').load('<?=site_url('proposal/get_modal_budget')?>', {activity:activity, tahun:tahun, code_brand, month : month}); 
    })

    $('#table_budget').DataTable({
        ordering : false,
        searching : false,
        info : false,
        scrollY: '190px',
        scrollCollapse: true,
        paging: false,
    })



</script>
<script>
</script>