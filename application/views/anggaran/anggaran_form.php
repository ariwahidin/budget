<!-- <?php 
    $start_month = 7;
    $end_month = 6;
    $s = $start_month;
    $e = $end_month;
    $bulan = $start_month;
    $start_year = 2022;
    $end_year = 2024;
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
        echo $bulan." ".$tahun."<br>";
        $bulan++;
    }
?> -->





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

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="pull-right">
                <a href="<?=site_url('anggaran')?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?=site_url('anggaran/process')?>" method="post">

                        <div class="row">
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label for="">Nomor Anggaran</label>
                                    <input type="text" name="no_anggaran" value="<?=$no_anggaran?>" class="form-control" style="text-transform:uppercase" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="anggaran_name">Approval</label>
                                    <select name="budget_code" id="anggaran_option" class="form-control select2" required>
                                            <option value="">-- Pilih --</option>
                                        <?php foreach($budget->result() as $data){ ?>
                                            <option value="<?=$data->budget_code?>"><?=$data->budget_name?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Pic.</label>
                                    <select name="pic_code" id="anggaran_option" class="form-control select2" required>
                                            <option value="">-- Pilih --</option>
                                        <?php foreach($pic->result() as $data){ ?>
                                            <option value="<?=$data->nik?>"><?=$data->namakaryawan?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Start Month</label>
                                            <select name="start_month" id="" class="form-control select2" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Start Year</label>
                                            <select name="start_year" id="" class="form-control select2" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">End Month</label>
                                            <select name="end_month" id="" class="form-control select2" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">End Year</label>
                                            <select name="end_year" id="" class="form-control select2" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" name="<?=$page?>" class="btn btn-success btn-flat">
                                        <i class="fa fa-paper-plane"></i> Proses
                                    </button>
                                    <button type="Reset" class="btn btn-flat">Reset</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function(){
        $('.select2').select2();
    })
</script>