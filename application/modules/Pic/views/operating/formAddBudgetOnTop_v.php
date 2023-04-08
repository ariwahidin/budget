<?php
// var_dump($budget_code);
// var_dump($month->result());
// var_dump($brand->result());
?>

<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Add Budget On Top</h1>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <table>
                    <tr>
                        <td>Brand</td>
                        <td>&nbsp;:&nbsp;<?= $brand->row()->BrandName ?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>&nbsp;:&nbsp;<?= date('M-Y', strtotime($month->result()[0]->month)) . ' s/d ' . date('M-Y', strtotime($month->result()[11]->month)) ?></td>
                    </tr>
                </table>
            </div>
            <div class="box-body">
                <form id="form_on_top">
                    <input type="hidden" name="budget_code" value="<?= $budget_code ?>">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <?php foreach ($month->result() as $bulan) { ?>
                                    <th><?= date('M-Y', strtotime($bulan->month)) ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php foreach ($month->result() as $bln) { ?>
                                    <td style="padding:0!important;">
                                        <input type="hidden" name="month[]" value="<?= $bln->month ?>">
                                        <input value="0" name="on_top[]" onkeypress="javascript:return isNumber(event)" onkeyup="reset_to_zero(this); formatNumber(this); calculateTotal();" type="text" class="form-control on_top">
                                    </td>
                                <?php } ?>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><b>Total</b></td>
                                <td colspan="11"></td>
                            </tr>
                            <tr>
                                <td style="padding:0!important;">
                                    <input type="text" id="total_on_top" class="form-control" readonly>
                                </td>
                                <td colspan="11"></td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
            <div class="box-footer">
                <button onclick="simpanOnTop()" class="btn btn-primary pull-right">Simpan Data</button>
            </div>
        </div>
    </section>
</div>
<?php $this->view('footer') ?>
<script>
    function reset_to_zero(elem) {
        if (elem.value == '') {
            elem.value = 0;
        }
    }

    function calculateTotal() {
        var on_top = document.querySelectorAll('input.on_top');
        var input_total_on_top = document.getElementById('total_on_top');
        var total_on_top = 0;
        for (var i = 0; i < on_top.length; i++) {
            total_on_top += parseFloat(on_top[i].value.replace(/,/g, ''));
        }
        input_total_on_top.value = total_on_top.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function simpanOnTop() {
        var form = document.getElementById('form_on_top');
        form.action = '<?= base_url($_SESSION['page'] . '/simpanBudgetOnTop/') ?>';
        form.method = 'POST';
        form.submit();
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function formatNumber(num) {
        var value = num.value.replace(/,/g, '');
        value = parseFloat(value);
        return num.value = isNaN(value) ? '' : value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>