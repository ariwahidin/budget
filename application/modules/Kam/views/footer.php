<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2021-2022 <a href="">Pandurasa Kharisma</a>.</strong> All rights
    reserved.
</footer>
<div class="control-sidebar-bg"></div>
</div>
<div class="modal fade bannerformmodal" tabindex="-1" role="dialog" aria-labelledby="bannerformmodal" aria-hidden="true" id="bannerformmodal">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">AVG SALES</h4>
            </div>
            <div class="modal-body">
                <table class="table table-responsive table-bordered">
                    <!-- <?php var_dump(getGroupCustomer()->result()) ?> -->
                    <tr>
                        <form action="<?= base_url($_SESSION['page'] . '/show_create_from_sales') ?>" method="POST">
                            <td>
                                LAST 3 MONTH
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">SELECT</button>
                            </td>
                        </form>
                        <!-- <td><a class="btn btn-primary" href="<?= base_url($_SESSION['page'] . '/show_create_from_sales') ?>">SELECT</a></td> -->
                    </tr>
                    <tr style="display:none;">
                        <td>LAST YEAR</td>
                        <td><a class="btn btn-primary" href="">SELECT</a></td>
                    </tr>
                    <tr>
                        <td>NON SALES</td>
                        <td><a class="btn btn-primary" href="<?= base_url($_SESSION['page'] . '/createProposal') ?>">SELECT</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
<script>
</script>

<script type="text/javascript">
    $('.select2').select2();
    $("#table1").DataTable()

    function loadingShow() {
        var div_loading = document.getElementById("muncul_loading");
        div_loading.classList.add("loading");
    }

    function loadingHide() {
        var div_loading = document.getElementById("muncul_loading");
        if (div_loading.classList.contains("loading") == true) {
            div_loading.classList.remove("loading")
        }
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

    function reset_to_zero(elem) {
        if (elem.value == '') {
            elem.value = 0;
        }
    }
</script>

</html>