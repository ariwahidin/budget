<?php
    // var_dump($anggaranDetail->result());
    $row = $anggaranDetail->result();
    $no_anggaran = $row[0]->no_anggaran;
    $brand_code = $row[0]->brand_code;
    $tahun = $row[0]->tahun;
    $start_month = $row[0]->start_month;
    $end_month = $row[0]->end_month;
    $start_year = $row[0]->start_year;
    $end_year = $row[0]->end_year;
    $subtotal = 0;
    foreach($anggaranDetail->result() as $data){
        $subtotal += $data->budget;
    }
    
?>
<style>
    th, td { white-space: nowrap; }
</style>

<section class="content-header">
    <h1>
    Tambah Activity Anggaran
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Tambah Acivity Anggaran</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <a href="<?=site_url('anggaran')?>">
                        <button class="btn btn-primary pull-right"><i class="fa fa-rotate-left"></i> Back</button>
                    </a>
                </div>
                <div class="box-body">
                    <table>
                        <tr>
                            <td>No. Anggaran </td>
                            <td>&nbsp;:&nbsp;</td>
                            <td id="no_anggaran"><?=$no_anggaran?></td>
                        </tr>
                        <tr>
                            <td>Brand</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?=getBrandName($brand_code)?></td>
                        </tr>
                        <tr>
                            <td>Periode</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?=$tahun?></td>
                        </tr>
                        <tr>
                            <td>Total Anggaran</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td>
                                <b id="totalAnggaran">
                                    <?=number_format($subtotal)?>
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td>Anggaran Actual</td>
                            <td>&nbsp;:&nbsp;</td>
                            <td>
                                <b id="showBudgetActual"></b> 
                                <input class="form-control" type="hidden" id="budgetActual" value="" readonly>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">

                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="stripe row-border order-column" id="table_activity" width="">
                                <thead>
                                    <tr>
                                        <th style="background-color:white; z-index:1;">No. </th>
                                        <th style="background-color:white; z-index:1;">
                                           Activity
                                        </th>
                                        <th style="background-color:white; z-index:1;">
                                            <label for="">Presentase (%)</label>
                                            <input id="total_presentase" type="text" class="form-control" readonly>
                                        </th>
                                        <?php foreach($anggaranDetail->result() as $data) {?>
                                        <th class="th_budget">
                                            <label for=""><?=getMonth($data->bulan).' '.$data->tahun?></label>
                                            <input type="text" class="form-control" readonly value="<?=number_format($data->budget)?>">
                                            <input id="budget_bulan_<?=$data->bulan?>" type="hidden" value="<?=$data->budget?>">
                                            <input id="actual_activity_budget_<?=$data->bulan?>" type="hidden" class="form-control" readonly value="">
                                            <!-- <input id="actual_activity_budget_show_<?=$data->bulan?>" type="text" class="form-control" readonly value=""> -->
                                        </th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no=1; foreach($activity->result() as $act){?>
                                        <tr>
                                            <td width="5px" style="background-color:white;"><?=$no++?></td>
                                            <td style="background-color:white;"><?=$act->promo_name?></td>
                                            <td width=5%; style="background-color:white;">
                                                <input class="form-control presentase_per_activity" type="number">
                                            </td>
                                            <?php foreach($anggaranDetail->result() as $data){?>
                                                <td class="data_activity" width="">
                                                    <input class="activityId" type="hidden" value="<?=$act->id?>">
                                                    <input class="month" type="hidden" value="<?=$data->bulan?>">
                                                    <input class="tahun" type="hidden" value="<?=$data->tahun?>">
                                                    <input class="bdgt" type="hidden" value="<?=$data->budget?>">
                                                    <input class="bdgt_prsnt" type="hidden" value="">
                                                    <input id="" onkeypress="CheckNumeric(event);" class="nominal nominal_<?=$data->bulan?> form-control" type="text"  value="" data-type="number" readonly>
                                                    <!-- <input id="" class="nominalSum nominal_<?=$data->bulan?> form-control" type="text"  value="" data-type="number"> -->
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <!-- <a href=""> -->
                        <button id="btnSimpanAnggaranActivity" class="btn btn-primary pull-right">Simpan</button>
                    <!-- </a> -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    $(document).ready(function(){
        
        $(document).on('keyup','.presentase_per_activity', function(){
            var td = $(this).parent().parent()[0].cells;
            var presentase = $(this).val();
            for(var i = 3; i < td.length; i++){
                var budget = td[i].querySelector("input.bdgt").value;
                if(presentase != ''){
                    var result = parseFloat(budget) * (parseFloat(presentase)/100); 
                    var cek = td[i].querySelector("input.nominal").value = numberWithCommas(Math.floor(result));
                    var prsnt = td[i].querySelector("input.bdgt_prsnt").value = presentase; 
                }else{
                    var cek = td[i].querySelector("input.nominal").value = '';
                }
                // console.log(td[i]);
                // console.log(budget);
            }
            calculate();
            calculate_presentase();
        })

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function calculate_presentase(){
            var ps = document.getElementsByClassName('presentase_per_activity');
            var totps = document.getElementById('total_presentase');
            var num = 0;
            for(var i = 0 ; i < ps.length ; i++){
                if(ps[i].value != ''){
                    num += parseFloat(ps[i].value);
                }
            }
            totps.value = num;
            // console.log(num);
        }

        function calculate(){
            var nominal = $('.nominal');
            var totalNominal = parseFloat(0);
            for(var i = 0; i < nominal.length ; i++){
                if(nominal[i].value != ''){
                    totalNominal += parseFloat(nominal[i].value.replace(/,/g, ''));
                }
            }
            $('#showBudgetActual')[0].innerText = totalNominal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $('#budgetActual').val(totalNominal);
        }
    })

    
</script>

<script>
    // $(document).ready(function(){
    //     $('.nominal').on('change', function(){
    //         var nominal = $('.nominal');
    //         var totalNominal = parseFloat(0);
    //         for(var i = 0; i < nominal.length ; i++){
    //             if(nominal[i].value != ''){
    //                 totalNominal += parseFloat(nominal[i].value.replace(/,/g, ''));
    //             }
    //         }
    //         $('#showBudgetActual')[0].innerText = totalNominal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //         $('#budgetActual').val(totalNominal);
    //     })
    // })
</script>
<script>
    // $(document).ready(function(){
    //     $("input[data-type='number']").keyup(function(event){
    //         // skip for arrow keys
    //         if(event.which >= 37 && event.which <= 40){
    //             event.preventDefault();
    //         }
            
    //         var $this = $(this);
    //         var num = $this.val().replace(/,/gi, "");
    //         var num2 = num.split(/(?=(?:\d{3})+$)/).join(",");
    //         $this.val(num2);
    //     });
    // });
</script>

<script>
    // $(document).on("keyup", ".nominal_1", function() {
	//     var sum1 = 0;
	//     $(".nominal_1").each(function(){
	//         sum1 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_1').val()) < parseFloat(sum1)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_1").val(sum1);
    //         $("#actual_activity_budget_show_1").val(sum1.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_2", function() {
	//     var sum2 = 0;
	//     $(".nominal_2").each(function(){
	//         sum2 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_2').val()) < parseFloat(sum2)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_2").val(sum2);
    //         $("#actual_activity_budget_show_2").val(sum2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_3", function() {
	//     var sum3 = 0;
	//     $(".nominal_3").each(function(){
	//         sum3 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_3').val()) < parseFloat(sum3)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_3").val(sum3);
    //         $("#actual_activity_budget_show_3").val(sum3.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_4", function() {
	//     var sum4 = 0;
	//     $(".nominal_4").each(function(){
	//         sum4 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_4').val()) < parseFloat(sum4)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_4").val(sum4);
    //         $("#actual_activity_budget_show_4").val(sum4.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_5", function() {
	//     var sum5 = 0;
	//     $(".nominal_5").each(function(){
	//         sum5 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_5').val()) < parseFloat(sum5)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_5").val(sum5);
    //         $("#actual_activity_budget_show_5").val(sum5.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_6", function() {
	//     var sum6 = 0;
	//     $(".nominal_6").each(function(){
	//         sum6 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_6').val()) < parseFloat(sum6)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_6").val(sum6);
    //         $("#actual_activity_budget_show_6").val(sum6.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_7", function() {
	//     var sum7 = 0;
	//     $(".nominal_7").each(function(){
	//         sum7 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_7').val()) < parseFloat(sum7)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_7").val(sum7);
    //         $("#actual_activity_budget_show_7").val(sum7.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_8", function() {
	//     var sum8 = 0;
	//     $(".nominal_8").each(function(){
	//         sum8 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_8').val()) < parseFloat(sum8)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_8").val(sum8);
    //         $("#actual_activity_budget_show_8").val(sum8.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_9", function() {
	//     var sum9 = 0;
	//     $(".nominal_9").each(function(){
	//         sum9 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_9').val()) < parseFloat(sum9)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_9").val(sum9);
    //         $("#actual_activity_budget_show_9").val(sum9.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_10", function() {
	//     var sum10 = 0;
	//     $(".nominal_10").each(function(){
	//         sum10 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_10').val()) < parseFloat(sum10)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_10").val(sum10);
    //         $("#actual_activity_budget_show_10").val(sum10.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_11", function() {
	//     var sum11 = 0;
	//     $(".nominal_11").each(function(){
	//         sum11 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_11').val()) < parseFloat(sum11)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_11").val(sum11);
    //         $("#actual_activity_budget_show_11").val(sum11.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

    // $(document).on("keyup", ".nominal_12", function() {
	//     var sum12 = 0;
	//     $(".nominal_12").each(function(){
	//         sum12 += +$(this).val().replace(/,/g, '');
	//     });
    //     if(parseFloat($('#budget_bulan_12').val()) < parseFloat(sum12)){
    //         alert("Set budget activity tidak boleh melebihi total budget perbulan")
    //     }else{
    //         $("#actual_activity_budget_12").val(sum12);
    //         $("#actual_activity_budget_show_12").val(sum12.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    //     }
	// });

</script>

<script type="text/javascript">
    $('.select2').select2();
    $('#table_activity').DataTable({
        ordering : false,
        searching : false,
        info : false,
        scrollY : "400px",
        // scrollX : true,
        // scrollCollapse : true,
        paging : false,
        fixedColumns : {
            left: 2,
        }
    })
    $('#btnSimpanAnggaranActivity').on('click', function(){
        // alert('proses simpan');
        var no_anggaran = $('#no_anggaran').text();
        var data_activity =$('.data_activity');

        var activity = $('.activityId');
        var month = $('.month');
        var nominal = $('.nominal');
        var tahun = $('.tahun');
        var presentase = $('.bdgt_prsnt');
        var isi_activity = [];
        var isi_month = [];
        var isi_nominal = [];
        var isi_tahun = [];
        var isi_presentase = [];
        for( var i = 0 ; i < data_activity.length ; i++){
                isi_activity.push(activity[i].value);         
                isi_month.push(month[i].value);         
                isi_nominal.push(nominal[i].value);         
                isi_tahun.push(tahun[i].value);
                isi_presentase.push(presentase[i].value)         
        }
        var totaAnggaran = $('#totalAnggaran')[0].innerText;
        totalAnggaran = parseFloat(totaAnggaran.replace(/,/g, ''));
        if(parseFloat($('#budgetActual').val()) > totalAnggaran){
            alert('Budget Actual lebih besar dari Total Anggaran');
        }else if(parseFloat($('#total_presentase').val()) < 100){
            alert('Presentase dibawah 100%');
        }else if($('#budgetActual').val() == ''){
            alert('Budget Actual Kosong');
        }else{
            if (confirm("Data Budget Sudah Sesuai, Yakin Simpan Proses Ini?") == true) {
                $.ajax({
                    url : '<?=site_url('anggaran/simpanAnggaranActivity')?>',
                    type : 'POST',
                    data : {
                        no_anggaran,
                        brand_code : '<?=$brand_code?>',
                        start_year : '<?=$start_year?>',
                        end_year : '<?=$end_year?>',
                        isi_activity,
                        isi_month,
                        isi_nominal,
                        isi_tahun,
                        isi_presentase,
                    },
                    dataType : 'JSON',
                    success: function(response){
                        if(response.success == true){
                            alert('Activity berhasi disimpan');
                            window.location='<?=site_url('anggaran/lihatAnggaranActivity/')?>'+no_anggaran;
                        }
                    },
                })
            } else {
                alert("You canceled!");
            }
        }
    })
</script>