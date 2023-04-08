<div class="box">
    <div id="box-body-customer" class="box-body table-responsive">
        <table class="table table-bordered" id="table_cust">
            <thead>
                <tr>
                    <th>Group Customer</th>
                    <th>Customer Name</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="tbody_customer">
            </tbody>
        </table>
    </div>
    <div class="box-footer text-right">
        <div class="input-group">
            <input id="customer_id" type="hidden">
            <input type="hidden" id="cust" class="form-control" readonly>
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary" id="buttonTampilModalCustomer">
                    <i class="fa fa-plus"> Add Customer</i>
                </button>
            </span>
        </div> 
    </div>
</div>
<div id="muncul-modal-customer"></div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#buttonTampilModalCustomer').on('click', function(){
            $('#muncul-modal-customer').load('<?=site_url('ProposalPromosi_C/showModalCustomer')?>');
        });
    });
</script>