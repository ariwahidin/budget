<?php
// var_dump($periode);
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Create Operating</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <table>
                            <tr>
                                <td>Brand</td>
                                <td>&nbsp;:&nbsp; <?= getBrandName($brand) ?></td>
                            </tr>
                            <tr>
                                <td>Start Month</td>
                                <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($start_month)) ?></td>
                            </tr>
                            <tr>
                                <td>End Month</td>
                                <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($end_month)) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Month</th>
                                    <th>Operating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($periode as $month) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?= date('M - Y', strtotime($month)) ?>
                                            <input type="hidden" class="input_month" value="<?= $month ?>">
                                        </td>
                                        <td>
                                            <input onkeyup="calculate(this)" type="text" class="form-control input_operating">
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button onclick="simpan()" class="btn btn-primary pull-right">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->view('footer'); ?>
<script>
    $(document).ready(function() {

    });

    function calculate(e) {
        var value = e.value.replace(/,/g, '');
        value = value;
        e.value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function simpan() {
        var input_operating = document.querySelectorAll('input.input_operating');
        var input_month = document.querySelectorAll('input.input_month');
        var operating = [];
        var month = [];
        var brand = '<?= $brand ?>';
        
        for (var i = 0; i < input_operating.length; i++) {
            if(input_operating[i].value == '' || isNaN(parseFloat(input_operating[i].value.replace(/,/g, '')))){
                alert("Isian tidak valid")
                return false;
            }
            operating.push(input_operating[i].value);
            month.push(input_month[i].value);
        }

        $.ajax({
            url: "<?= base_url($_SESSION['page'] . '/simpanOperating') ?>",
            type: "POST",
            data: {
                brand,
                operating,
                month
            },
            dataType : "json",
            success: function(response) {
                if (response.success == true) {
                    window.location.href = "<?=base_url($_SESSION['page'] . '/showOperating') ?>";
                } else {
                    alert('gagal simpan Data')
                }
            }
        });
    }
</script>