<?php 
    // var_dump($anggaran);
?>

<section class="content-header">
    <h1>
    Tambah Anggaran
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="">Anggaran</li>
    <li class="active">Tambah Anggaran</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h4>Detail Tambah Anggaran</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <td>No. Anggaran</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><?=$anggaran['no_anggaran'];?></td>
                                </tr>
                                <tr>
                                    <td>Approval</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><?=getApproval($anggaran['budget_code']);?></td>
                                </tr>
                                <tr>
                                    <td>Periode</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td>
                                        <?=getMonth($anggaran['start_month'])?> -
                                        <?=$anggaran['start_year'];?>
                                        &nbsp;s/d&nbsp;
                                        <?=getMonth($anggaran['end_month'])?> -
                                        <?=$anggaran['end_year'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pic.</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><?=ucfirst(strtolower(getPic($anggaran['pic_code'])));?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-5">
                            <!-- <button class="btn btn-primary pull-right">
                                <i class="fa fa-plus"></i> Pilih Brand
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="anggaran_name">Brand</label>
                                <select name="" id="brand_code" class="form-control select2" required>
                                        <option value="">-- Pilih --</option>
                                    <?php foreach($brand->result() as $data){ ?>
                                        <option value="<?=$data->BrandCode?>"><?=$data->BrandName?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <?php 
                        // var_dump($anggaran);
                    ?>
                    <table class="table table-bordered" id="table_form" width="1800px">
                        <thead>
                            <tr>
                                <?php
                                $start_month = $anggaran['start_month'];
                                $end_month = $anggaran['end_month'];
                                $s = $start_month;
                                $e = $end_month;
                                $bulan = $start_month;
                                $start_year = $anggaran['start_year'];
                                $end_year = $anggaran['end_year'];
                                $tahun = $start_year;
                                
                                if($end_year > $start_year){
                                    if($start_month > $end_month){
                                        $s = 1;
                                        $e = 12;
                                    }
                                }else if ($end_year < $start_year){
                                    echo "Tahun tidak bisa mundur";
                                }
                            
                                for($i = $s ; $i <= $e; $i++){
                                    
                                    if ($bulan == 13){
                                        $bulan = 1;
                                        $tahun++;
                                    }

                                echo "<th>".getMonth($bulan)." ".$tahun."</th>";
                                $bulan++;
                                } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $tahun = $start_year; 
                                for($i= $s; $i <= $e; $i++){ 
                                        if ($bulan == 13){
                                            $bulan = 1;
                                            $tahun++;
                                        }
                                    ?>
                                    <td width="150px">
                                        <input onkeypress="CheckNumeric(event);" id="bgt_<?=$bulan?>" class="nilai_anggaran form-control nilai" type="text" data-type="number">
                                        <input class="bulan_anggaran" value="<?=$bulan?>" type="hidden">
                                        <input class="tahun" type="hidden" value="<?=$tahun?>">
                                    </td>
                                <?php
                                $bulan++; 
                                } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-1 text-right">
                            <label for=""><strong>Total</strong></label>
                        </div>
                        <div class="col-md-2">
                            <input id ="subtotal" type="hidden" class="form-control" readonly>
                            <input id ="subtotal_show" type="text" class="form-control" readonly>
                        </div>
                        <div class="col-md-9">
                            <button id="simpan_budget" class="btn btn-primary pull-right">
                                <i class="fa fa-plane"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $("input[data-type='number']").keyup(function(event){
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40){
                event.preventDefault();
            }
            var $this = $(this);
            var num = $this.val().replace(/,/gi, "");
            var num2 = num.split(/(?=(?:\d{3})+$)/).join(",");
            // console.log(num2);
            // the following line has been simplified. Revision history contains original.
            $this.val(num2);
        });
    });
</script>
<script type="text/javascript">
    $(document).on("change", ".nilai", function() {
	    var sum = 0;
	    $(".nilai").each(function(){

            // console.log($(this).val().replace(/,/g, ''));
	        sum += +$(this).val().replace(/,/g, '');


	    });
        // console.log(sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $("#subtotal").val(sum);
        $("#subtotal_show").val(sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
	});
</script>

<script type="text/javascript">
    $('#table_form').DataTable({
        "scrollX": true,
        "searching": false,
        "paging": false,
        "bInfo": false,
    });
</script>



<script type="text/javascript">
    $(document).ready(function(){

        $('.select2').select2();

        $('#simpan_budget').on('click',function(){
            var brand_code = $('#brand_code').val();
            var no_anggaran = '<?=$anggaran['no_anggaran'];?>';
            // var budget_01 = $('#bgt_1').val();
            // var budget_02 = $('#bgt_2').val();
            // var budget_03 = $('#bgt_3').val();
            // var budget_04 = $('#bgt_4').val();
            // var budget_05 = $('#bgt_5').val();
            // var budget_06 = $('#bgt_6').val();
            // var budget_07 = $('#bgt_7').val();
            // var budget_08 = $('#bgt_8').val();
            // var budget_09 = $('#bgt_9').val();
            // var budget_10 = $('#bgt_10').val();
            // var budget_11 = $('#bgt_11').val();
            // var budget_12 = $('#bgt_12').val();

            var bulan_anggaran = document.getElementsByClassName("bulan_anggaran");
            var bulan_anggaran_isi = [];
            var anggaranClass = document.getElementsByClassName("nilai_anggaran");

            for(var i = 0; i < bulan_anggaran.length; i++){
                bulan_anggaran_isi.push(bulan_anggaran[i].value);
            }
            var nilai_anggaran = [];
            for(var a = 0; a < anggaranClass.length; a++){
                nilai_anggaran.push(anggaranClass[a].value);
            }
            var tahunClass = document.getElementsByClassName("tahun");
            var tahun = [];
            for(var t = 0; t < tahunClass.length; t++){
                tahun.push(tahunClass[t].value);
            }

            console.log(bulan_anggaran_isi);
            console.log(nilai_anggaran);
            console.log(tahun);
            if(brand_code == ''){
                alert('Brand Kosong');
            }else{
                $.ajax({
                    url : '<?=site_url('anggaran/simpanAnggaran')?>',
                    type : 'POST',
                    data : {
                        'sub_total' : $('#subtotal').val(),
                        'budget_code' : '<?=$anggaran['budget_code']?>',
                        'created_by' : '<?=$anggaran['pic_code']?>',
                        'user_sign' : '<?=$this->fungsi->user_login()->id?>',
                        'start_month' : '<?=$anggaran['start_month']?>',
                        'end_month' : '<?=$anggaran['end_month']?>',
                        'start_year' : '<?=$anggaran['start_year']?>',
                        'end_year' : '<?=$anggaran['end_year']?>',
                        'brand_code' : brand_code,
                        'anggaran_code' : no_anggaran,
                        'tahun_anggaran' : tahun,
                        'nilai_anggaran' : nilai_anggaran,
                        'bulan_anggaran' : bulan_anggaran_isi,
                    },
                    dataType : 'JSON',
                    success : function(response){
                        if(response.success == true){
                            alert('Data Budget Berhasil Disimpan');
                            window.location.href = '<?=site_url('anggaran')?>';
                        }
                    }
                })
            }
        })
    })
</script>