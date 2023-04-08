<?php 
    // var_dump($brand);
?>
<div class="modal fade" id="modal-set-new-budget" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Set New Budget</h4>
            </div>
            <div class="modal-body">
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Periode Budget</label>
                        <div class="col-sm-10">
                            <select name="" id="periode_budget" class="form-control select2" style="width: 100% !important">
                                <option value="" disabled selected>-- Pilih Tahun --</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Brand</label>
                        <div class="col-sm-10">
                            <select name="" id="brand_code_nonsales" class="form-control select2" style="width: 100% !important">
                                <option value="" disabled selected>-- Pilih Brand --</option>
                                <?php foreach($brand->result() as $data) {?>
                                    <option value="<?=$data->BrandCode?>"><?=$data->BrandName?></option>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Periode Purchase</label>
                        <div class="col-sm-5">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="periodeStartDate" autocomplte="off">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="periodeEndDate" autocomplte="off">
                            </div>
                        </div>
                    </div>
                    <button id="create_new_budget" class="btn btn-info pull-right">
                       <i class="fa fa-arrow-circle-right"></i> Set Budget
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#modal-set-new-budget').modal('show');
        $('.select2').select2();
        
        var StartDate = $('#periodeStartDate').datepicker({format: 'dd-mm-yyyy', autoclose: true,});
        var EndDate = $('#periodeEndDate').datepicker({autoclose: true, format: 'dd-mm-yyyy'});
        
        $('#create_new_budget').on('click', function(){

            var diffMonth = monthDiff(new Date(myDate(StartDate.val())), new Date(myDate(EndDate.val())));
            var myPeriodeDate = periodeDate(myDate(StartDate.val()));
            var code_branded = $('#brand_code_nonsales').val();
            var startPurchaseDate = myDate(StartDate.val());
            var endPurchaseDate = myDate(EndDate.val());
            var checkBudgetSettedss = checkBudgetSetted(code_branded,startPurchaseDate,endPurchaseDate);

            // console.log(checkBudgetSettedss.budget_setted);

            if(diffMonth != 11){
                alert('Periode purchase harus 12 bulan');
            }else if(checkBudgetSettedss.budget_setted == true){
                alert('Budget dengan periode purchase tersebut sudah ada');
            }else{

                $(document).ajaxSend(function(){
                    $("#overlay").fadeIn(300);　
                });

                $.ajax({
                    url: '<?=site_url('Anggaran_C/checkBudget')?>',
                    type: 'POST',
                    data : {
                        'code_brand' : $('#brand_code_nonsales').val(),
                        'start_date' : StartDate.val(),
                        'end_date' : EndDate.val(),
                    },
                    dataType : 'JSON',
                    success: function(response){
                        if(response.success == true){
                            // alert('data ada');
                            var purchase = response.purchase;
                            var start_date = StartDate.val();
                            var end_date = EndDate.val();
                            var code_brand = $('#brand_code_nonsales').val();
                            var periode_budget = $('#periode_budget').val();
                            $('#modal-set-new-budget').modal('hide');
                            $('#show_modal_set_new_budget_from_purchase').load('<?=site_url('Anggaran_C/showModalSetBudgetFromPurchase')?>',{purchase, start_date, end_date, code_brand, periode_budget, myPeriodeDate});
                        }else{
                            alert('data tidak ditemukan');
                        }
                    }
                }).done(function(){setTimeout(function(){
                    $("#overlay").fadeOut(300);
                },500);});
            }
        })

        function checkBudgetSetted(code_brand,startPurchaseDate,endPurchaseDate){
           var cek =  $.ajax({
                url : '<?=site_url('Anggaran_C/checkBudgetSetted')?>',
                type : 'POST',
                async:false,
                data : {
                    code_brand,
                    startPurchaseDate,
                    endPurchaseDate
                },
                dataType : 'JSON',
                success: function(response){
                    return response.budget_setted;
                }
            });
            return JSON.parse(cek.responseText);
        }

        function monthDiff(d1, d2) {
            var months;
            months = (d2.getFullYear() - d1.getFullYear()) * 12;
            months -= d1.getMonth();
            months += d2.getMonth();
            return months <= 0 ? 0 : months;
        }

        function periodeDate(startDate){
            var year = startDate.substr(0, 4);
            var month = startDate.substr(5, 2);
            var day = startDate.substr(8, 2);
            var x = 11;
            var c = []
            for(var i = 0 ; i <= x ; i++){
                month = parseInt(month);
                if(month == 13){
                    month = 1;
                    year++;
                }
                month = String(month);
                if (month < 10){
                    month = '0'+month;
                }
                var date = year+'-'+month+'-'+day;
                c.push(date);
                month++;
            }
            return c;
        }

        function myDate(date){
            var day = date.substr(0, 2);
            var month = date.substr(3, 2);
            var year = date.substr(6, 4);
            return year+'-'+month+'-'+day;
        }

    });
</script>