<?php 
// var_dump($budget);
?>
<section class="content-header">
    <h1>
    Data Pembelian
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Data Pembelian</li>
    </ol>
</section>

<section class="content">

    <div class="box">
        <div class="">
        </div>
        <div class="box-body table-responsive">

            <table class="table table-bordered table-striped" id="table_master_budget">
                <thead>
                    <tr>
                        <th style="background-color:white; z-index:1;">No.</th>
                        <!-- <th>Card Name</th> -->
                        <th style="background-color:white; z-index:1;">Code Brand</th>
                        <th style="background-color:white; z-index:1;">Brand</th>
                        <th style="background-color:white; z-index:1;">Year</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>April</th>
                        <th>Mei</th>
                        <th>Juni</th>
                        <th>Juli</th>
                        <th>Agustus</th>
                        <th>September</th>
                        <th>Oktober</th>
                        <th>November</th>
                        <th>Desember</th>
                        <!-- <th style="background-color:white; z-index:1;">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach($budget->result() as $key => $data){ ?>
                    <tr>
                        <td style="background-color:white;"><?=$no++ ?>.</td>
                        <!-- <td><?= $data->CardName?></td> -->
                        <td class="code_brand" style="background-color:white;"><?= $data->CodeBrand?></td>
                        <td style="background-color:white;"><?= $data->BRAND?></td>
                        <td class="tahun" style="background-color:white;"><?= $data->Year?></td>
                        
                        <td class="nilai_pembelian">
                            <?= number_format($data->Jan)?>
                            <input class="bulan" type="hidden" value="1">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->Feb)?>
                            <input class="bulan" type="hidden" value="2">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->Mar)?>
                            <input class="bulan" type="hidden" value="3">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->Apr)?>
                            <input class="bulan" type="hidden" value="4">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->May)?>
                            <input class="bulan" type="hidden" value="5">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->Jun)?>
                            <input class="bulan" type="hidden" value="6">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->Jul)?>
                            <input class="bulan" type="hidden" value="7">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->Aug)?>
                            <input class="bulan" type="hidden" value="8">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->Sep)?>
                            <input class="bulan" type="hidden" value="9">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->Oct)?>
                            <input class="bulan" type="hidden" value="10">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->Nov)?>
                            <input class="bulan" type="hidden" value="11">
                        </td>
                        <td class="nilai_pembelian">
                            <?= number_format($data->Dec)?>
                            <input class="bulan" type="hidden" value="12">
                        </td>
                        <!-- <td style="background-color:white;">
                            <button id="set_budget" class="btn btn-primary btn-xs">Set Budget</button>
                        </td> -->
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>
</section>
<div id="muncul_modal_setBudget"></div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#table_master_budget').DataTable({
            ordering : true,
            // searching : false,
            info : true,
            scrollX : true,
            scrollCollapse : true,
            // paging : false,
            fixedColumns : {
                left: 4,
            }
        });
    })
</script>
<script>
    $(document).on('click', '#set_budget', function(){
        var td = $(this).closest('tr');
        td = td[0];
        var code_brand = td.getElementsByClassName("code_brand");
        code_brand = code_brand[0].innerText;
        var tahun = td.getElementsByClassName("tahun");
        tahun = tahun[0].innerText;
        var crot = td.getElementsByClassName("nilai_pembelian");
        var bulan = td.getElementsByClassName("bulan");
        var month = [];
        var angka = [];
        for(var i = 0; i < crot.length; i++){
            if(crot[i].innerText != 0){
                month.push(bulan[i].value);
                angka.push(crot[i].innerText);
            }
        }
        // console.log(code_brand);
        // console.log(tahun);
        // console.log(month);
        // console.log(angka);
        $('#muncul_modal_setBudget').load('<?=site_url('pembelian/set_budget')?>', {
            code_brand : code_brand,
            tahun : tahun,
            bulan : month,
            nominal : angka,
        });
    })
</script>