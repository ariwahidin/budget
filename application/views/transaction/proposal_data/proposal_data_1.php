<?php 
    //  var_dump($activity->result());
?>
<style>
    #myDivAvg, #myDivCust {
        display: none;
    }
</style>
<section class="content-header">
    <h1>
    Daftar Proposal
    <small>Proposal Promotion</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="#">Proposal Promotion</a></li>
    <li class="active">Data Proposal</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box_title">Data Proposal Promotion</h3>
            <div class="pull-right">
                <button id="buat_baru" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i> Buat Baru
                </button>
            </div>
        </div>
        <div class="box-body table-responsive ttp"></div>
    </div>
</section>

<div class="modal fade" id="modal-buat-proposal">
    <div class="modal-dialog modal-md">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Buat Proposal</h3>
            </div>
            <div class="box-body">
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Periode:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input id="periode" name="periode" type="text" class="form-control pull-right" id="periode" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Brand:</label>
                            <div class="input-group">
                                <select id="brand_code" name="brand_code" class="form-control select2 pull-right" style="width:200px">
                                    <option value="">-- PIlih --</option>
                                    <?php foreach($brand->result() as $data) {?>
                                        <option value="<?=$data->BrandCode?>"><?=$data->BrandName?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Activity:</label>
                            <div class="input-group">
                                <select id="activity_id" name="activity_id" class="select2" style="width:200px" required>
                                        <option value="">-- PIlih --</option>
                                    <?php foreach($activity->result() as $data) {?>
                                        <option value="<?=$data->id?>"><?=getActivityName($data->id)?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="box-footer">
                <button id="buat_proposal" type="submit" href="" class="btn btn-primary pull-right">
                    <i class="fa fa-plane"> Proses</i>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="muncul_modal_addCustomer"></div>

<script>
    function myFunction() {
        var x = document.getElementById("myDivAvg");
        var y = document.getElementById("myDivCust");
        var checked = $('#cb_from_sales')[0].checked;
        if (x.style.display === "block" && y.style.display === "block") {
            if(checked == false){
                x.style.display = "none";
                y.style.display = "none";
            }
        } else {
            if(checked == true){
                x.style.display = "block";
                y.style.display = "block";
            }
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#cari_customer', function(){
            var brand = $('#brand_code').val();
            var periode = $('#periode').val();
            var tahun = periode.substring(6,10);
            if(brand == '' || tahun == ''){
                alert('Semua data wajib diisi');
            }else{
                $('#muncul_modal_addCustomer').load('<?=site_url('proposal/cariCustomer')?>',{brand:brand, tahun:tahun});
            }
        })
    })
</script>

<script type="text/javascript">
    $(document).on('click','#buat_proposal', function(){
        var array = [];
        var brand = $('#brand_code').val();
        var periode = $('#periode').val();
        var sales_avg = $('#sales_avg').val();
        var tahun = periode.substring(6,10);
        var bulan = periode.substring(3,5); 
        var activity = $('#activity_id').val();
        var code_budget = brand.concat(tahun, activity);
        var customer_code = $('#customer_code').val();
        var from_sales = $('#cb_from_sales')[0].checked;
        if(brand == '' || tahun == '' || activity == ''){
            alert('Semua wajib diisi');
        }else{
            if(from_sales == true){
                if(sales_avg == '' || customer_code == ''){
                    alert('Avg Sales dan Customer Harus Diisi');
                }else{
                    buatProposal();
                }
            }else{
                buatProposal();
            }
        }
        function buatProposal(){
            $.ajax({
                url: '<?=site_url('proposal/buatProposal')?>',
                type : 'POST',
                data : {
                    code_brand : brand,
                    tahun : tahun,
                    bulan : bulan,
                    sales_avg : sales_avg,
                    code_budget : code_budget,
                    customer_code: customer_code,
                    from_sales: from_sales,
                },
                dataType : 'JSON',
                success : function(response){
                    if(response.success == false){
                        alert('Budget untuk data yang diinginkan tidak ada');
                    }else if(response.check == false){
                        alert('Tidak ada data sales yang diingikan');
                    }else{
                        var periode_ = $('#periode').val();
                        var start_date = periode_.substring(0,10)
                        var end_date = periode_.substring(13,23);
                        var url = "<?=site_url('proposal/formProposal/')?>"+brand+"/"+activity+"/"+start_date+"/"+end_date+"/"+from_sales+"/"+sales_avg;
                        // console.log(url);
                        location.href = url;
                    }
                },
            });
        }
    });
</script>

<script type="text/javascript">
    $(document).on('click', '#buat_baru', function(){
        $('#modal-buat-proposal').modal('show');
    })
    $(document).ready(function(){
        $('.select2').select2();
        $('#periode').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY',
            }
        })
    });
</script>

<script>
    $('#brand_filter').select2();
    $(document).ready(function(){
        $('.ttp').load('<?=site_url('ProposalData/getTransaksi')?>');
        $(document).on('click', '#filter', function(){
            // alert('proses filter');
            var no_doc = $('#no_doc').val();
            var brand = $('#brand_filter').val();
            if(no_doc != ''){
                $('.ttp').load('<?=site_url('ProposalData/getTransaksi/')?>'+no_doc);
            }else if(brand != ''){
                $('.ttp').load('<?=site_url('ProposalData/getTransaksi/')?>'+null+'/'+brand);
            }
        })
    })
</script>