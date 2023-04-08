<?php 
    // var_dump($activity->result());
?>
<div class="modal fade" id="modal-create_new">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a href="#formNonSales" data-toggle="tab">Regular</a>
                        </li>
                        <li>
                            <a href="#sales-chart" data-toggle="tab">From Sales</a>
                        </li>
                        <li class="pull-left header">
                            <i class="fa fa-inbox"></i> Create New Proposal
                        </li>
                    </ul>
                    <div class="tab-content no-padding">
                        <div class="chart tab-pane active" id="formNonSales" style="position: relative; height: auto;">
                            <div class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">Brand</label>
                                        <div class="col-sm-8">
                                            <select name="" id="brand_code_nonsales" class="form-control select2" style="width: 100% !important">
                                                <option value="" disabled selected>-- Pilih Brand --</option>
                                                <?php foreach($brand->result() as $data){ ?>
                                                <option value="<?=$data->BrandCode?>"><?=$data->BrandName?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Activity</label>
                                        <div class="col-sm-8">
                                            <select name="" id="activity_code" class="form-control select2" style="width: 100% !important" placeholder="Pilih Brand">
                                                <option value="" disabled selected>-- Pilih Activity --</option>
                                                <?php foreach($activity->result() as $data){ ?>
                                                <option value="<?=$data->id?>"><?=$data->promo_name?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Periode Proposal</label>
                                        <div class="col-sm-8">
                                            <input id="periodeProposal" name="periode" type="text" class="form-control pull-right" placeholder="Pilih periode" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Periode Budget</label>
                                        <div class="col-sm-8">
                                            <select name="" id="inputBudgetYear" class="form-control select2" style="width: 100% !important" placeholder="Pilih periode budget">
                                                <option value="" disabled selected>-- Pilih Periode Budget --</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button id="create_proposal_regular" class="btn btn-info pull-right">Create</button>
                                </div>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                            form from Sales
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#modal-create_new').modal('show');
        $('.select2').select2();
        $('#periodeProposal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD-MM-YYYY',
            }
        });
        var start_date ='';
        var end_date ='';

        $('input[name="periode"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' s/d ' + picker.endDate.format('DD-MM-YYYY'));
            start_date = picker.startDate.format('DD-MM-YYYY');
            end_date = picker.endDate.format('DD-MM-YYYY');
        });

        $('#create_proposal_regular').on('click', function(e){
            const brand_code = $('#brand_code_nonsales').val();
            const activity_code = $('#activity_code').val();
            buat_proposal_regular(brand_code, activity_code, start_date, end_date);
        })

        function buat_proposal_regular(brand_code, activity_code, start_date, end_date){
            $.ajax({
                url : '<?=site_url('ProposalPromosi_C/createProposalRegular')?>',
                type : 'POST',
                data : {
                    brand_code : brand_code,
                    activity_code : activity_code,
                    budget_year : $('#inputBudgetYear').val(),
                    start_date : start_date,
                    end_date : end_date,
                    type_proposal : 'regular',
                },
                dataType : 'JSON',
                success: function(response){
                    if(response.success == true){
                        myRedirect(response);
                    }else if(response.checkBudget == false){
                        alert('Budget tidak tersedia');
                    }
                }

            })
        }

        function myRedirect (data){
            console.log(data);
            var form = document.createElement('form');
            form.action = "<?=site_url('ProposalPromosi_C/showFormProposalRegular')?>";
            form.method = "POST";
            var inputBrandCode = document.createElement('input');
            inputBrandCode.name = 'brand_code';
            inputBrandCode.value = data.code_brand;
            var inputNoProposal = document.createElement('input');
            inputNoProposal.name = 'no_proposal';
            inputNoProposal.value = data.no_proposal;
            var inputActivity = document.createElement('input');
            inputActivity.name = 'activity_code';
            inputActivity.value = data.activity_code;
            var inputStartDate = document.createElement('input');
            inputStartDate.name = 'start_date';
            inputStartDate.value = data.start_date;
            var inputEndDate = document.createElement('input');
            inputEndDate.name = 'end_date';
            inputEndDate.value = data.end_date;
            var inputTypeProposal = document.createElement('input');
            inputTypeProposal.name = 'type_proposal';
            inputTypeProposal.value = data.type_proposal;
            var inputTotalActualBudget = document.createElement('input');
            inputTotalActualBudget.name = 'total_actual_value_budget';
            inputTotalActualBudget.value = data.total_actual_budget_value;
            var inputDataBudget = document.createElement('input');
            inputDataBudget.name = 'input_budget';
            inputDataBudget.value = JSON.stringify(data.budget);

            form.appendChild(inputBrandCode);
            form.appendChild(inputNoProposal);
            form.appendChild(inputActivity);
            form.appendChild(inputStartDate);
            form.appendChild(inputEndDate);
            form.appendChild(inputTypeProposal);
            form.appendChild(inputTotalActualBudget);
            form.appendChild(inputDataBudget);
            document.body.appendChild(form);
            form.submit();
        }

    })

</script>