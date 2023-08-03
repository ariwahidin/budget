<?php
// var_dump($brand_code);
// var_dump($budget_code);
// var_dump($budget_detail_header->result());
// var_dump($budget_detail->result());
// var_dump($activity->result());
// die;
// var_dump($_SESSION['page']);
?>
<?php $this->view('header') ?>
<section class="content-wrapper">

    <section class="content-header">
        <div class="row">
            <div class="col col-md-6">
                <h4>Budget Detail</h4>
            </div>
            <div class="col col-md-6">
                <a class="btn btn-warning pull-right" href="<?= $_SERVER['HTTP_REFERER'] ?>"> Back</a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <table style="font-size:12px;">
                            <tr>
                                <td>Brand</td>
                                <td>&nbsp;:&nbsp; <?= getBrandName($budget_detail->row()->BrandCode) ?></td>
                            </tr>
                            <tr>
                                <td>Start Periode</td>
                                <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($budget_detail->result()[0]->Month)) ?></td>
                            </tr>
                            <tr>
                                <td>End Periode</td>
                                <td>&nbsp;:&nbsp; <?= date('M-Y', strtotime($budget_detail->result()[11]->Month)) ?></td>
                            </tr>

                            <tr>
                                <td>Principal Target</td>
                                <td>&nbsp;:&nbsp; <?= number_format($budget_detail_header->row()->TotalPrincipalTargetIDR) ?></td>
                            </tr>
                            <tr>
                                <?php
                                $target_anp = 0;
                                if ($budget_detail_header->row()->TotalPrincipalTargetIDR == 0) {
                                    $target_anp = 0;
                                } else {
                                    $target_anp = ($budget_detail_header->row()->TotalTargetAnp / $budget_detail_header->row()->TotalPrincipalTargetIDR);
                                }
                                $target_anp_percent = $target_anp * 100;
                                ?>
                                <td>Principal A&P</td>
                                <td>&nbsp;:&nbsp; <?= number_format($budget_detail_header->row()->TotalTargetAnp) ?></td>
                            </tr>
                            <tr>
                                <td>PK Target</td>
                                <td>&nbsp;:&nbsp; <?= number_format($budget_detail_header->row()->TotalPKTargetIDR) ?></td>
                            </tr>
                            <tr>
                                <td>PK A&P</td>
                                <td>&nbsp;:&nbsp; <?= number_format($budget_detail_header->row()->TotalPKAnpIDR) ?></td>
                            </tr>
                            <tr>
                                <?php
                                $operating = 0;
                                $operating = ($budget_detail_header->row()->TotalOperating / ($budget_detail_header->row()->TotalTargetAnp + $budget_detail_header->row()->TotalPKAnpIDR));
                                $operating_percent = $operating * 100;
                                ?>
                                <td>Operating (<?= round($operating_percent) ?>%)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($budget_detail_header->row()->TotalOperating); ?></td>
                            </tr>
                            <!-- <tr>
                                <td>Purchase</td>
                                <?php
                                $actual_purchase = getActualPurchase($budget_detail->row()->BrandCode, $budget_detail_header->row()->StartPeriode, $budget_detail_header->row()->EndPeriode);
                                ?>
                                <td>&nbsp;:&nbsp; <?= number_format($actual_purchase); ?></td>
                            </tr> -->
                            <tr style="display:none">
                                <?php
                                $total_actual_anp = 0;
                                $total_actual_anp = $actual_purchase * $target_anp;
                                ?>
                                <td>Actual A&P (<?= round($target_anp_percent) ?>%)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($total_actual_anp) ?></td>
                            </tr>
                            <!-- <tr>
                                <td>IMS</td>
                                <td>&nbsp;:&nbsp; <?= $is_ims ?></td>
                            </tr>
                            <tr>
                                <td>IMS (<?= $ims_percent ?>%)</td>
                                <td>&nbsp;:&nbsp; <?= number_format($ims_value) ?></td>
                            </tr> -->


                        </table>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped" style="font-size:12px;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <th><?= date('M-Y', strtotime($data->Month)) ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Principal Target</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format($data->PrincipalTargetIDR) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>Principal A&P</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format($data->TargetAnp) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>PK Target</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format($data->PKTargetIDR) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>PK A&P</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format($data->PKAnpIDR) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>Operating</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format($data->OperatingBudget) ?></td>
                                    <?php } ?>
                                </tr>
                                <!-- <tr>
                                    <td>Purchase</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format(getActualPurchasePerMonth($data->BrandCode, $data->Month)) ?></td>
                                    <?php } ?>
                                </tr> -->
                                <tr style="display:none">
                                    <td>Actual A&P</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format(getActualPurchasePerMonth($data->BrandCode, $data->Month) * $target_anp) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr style="display:none">
                                    <td>IMS</td>
                                    <?php foreach ($budget_detail->result() as $data) { ?>
                                        <td><?= number_format(getActualIMSPermonth($data->BrandCode, $data->Month, $ims_percent, $is_ims)) ?></td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <b>Activity A&P</b>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped" style="font-size:12px" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Activity</th>
                                    <th>(%)</th>
                                    <th>Budget</th>
                                    <th>Used</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $total_budget_activity = 0;
                                $total_used = 0;
                                $total_percent_activity = 0;
                                $total_balance = 0;
                                foreach ($budget_activity_report->result() as $bgg) {
                                    $total_budget_activity += $bgg->BudgetActivity;
                                    $total_used += $bgg->Used;
                                    $total_balance += $bgg->Saldo;
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $bgg->ActivityName ?></td>
                                        <td><?= $bgg->Percent ?></td>
                                        <td><?= number_format($bgg->BudgetActivity) ?></td>
                                        <td><?= number_format($bgg->Used) ?></td>
                                        <td><?= number_format($bgg->Saldo) ?></td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td><?= $total_percent_activity ?></td>
                                    <td><?= number_format($total_budget_activity) ?></td>
                                    <td><?= number_format($total_used) ?></td>
                                    <td></td>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Operating</th>
                                    <th>Used</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= number_format($total_budget_activity) ?></td>
                                    <td><?= number_format($total_used) ?></td>
                                    <td><?= number_format($total_budget_activity - $total_used) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- On Top -->
        <div class="row">
            <div class="col col-md-4" id="divOntop">
            </div>
            <div class="col col-md-3" id="divOnTopResume">
            </div>
        </div>
    </section>
</section>
<div id="modalLoadOnTop"></div>
<div id="modalLoadEditOnTop"></div>
<?php $this->view('footer') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.table-target-activity').DataTable({
            // scrollX: true,
        })

        $('.table-tracking-proposal').DataTable({
            // scrollX: true,
        });

        $('#divOntop').load("<?= base_url($_SESSION['page']) ?>/loadTableOnTop", {
            budget_code: "<?= $budget_code ?>"
        })

        $('#divOnTopResume').load("<?= base_url($_SESSION['page']) ?>/loadTableOnTopResume", {
            budget_code: "<?= $budget_code ?>"
        })
    });

    function loadModalEditOnTop(button) {
        const id = $(button).data('id')
        $('#modalLoadEditOnTop').load("<?= base_url($_SESSION['page']) ?>/loadModalEditOnTop", {
            id
        }, function() {
            $('#modal-edit-on-top').modal('show')
        })
    }

    function editOnTop(button) {
        const id = $(button).data('id')
        var oldOnTop = $('#old-on-top').val()
        var newOnTop = $('#new-on-top').val()
        if (parseFloat(newOnTop) > parseFloat(oldOnTop)) {
            $.ajax({
                url: "<?= base_url($_SESSION['page']) ?>/editOnTop",
                method: "POST",
                data: {
                    id,
                    oldOnTop,
                    newOnTop
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil edit data',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            $('#divOntop').load("<?= base_url($_SESSION['page']) ?>/loadTableOnTop", {
                                budget_code: "<?= $budget_code ?>"
                            })
                            $('#modal-edit-on-top').modal('hide')
                        })
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Gagal edit data',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            })
        } else {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'New value harus lebih besar',
                showConfirmButton: false,
                timer: 1500
            })
        }
    }

    function loadModalCreateOnTop(button) {
        const budget_code = $(button).data('budget-code')
        $('#modalLoadOnTop').load("<?= base_url($_SESSION['page']) ?>/loadCreateOnTop", {
            budget_code
        }, function() {
            $('#modal-create-on-top').modal('show')
        })
    }

    function createOnTop(button) {
        var budgetData = {};
        // Loop melalui setiap inputan dengan kelas "budget"
        var month = []
        var budget = []
        $(".budget").each(function() {
            var data_month = $(this).data("month"); // Mendapatkan bulan dari atribut data-month
            var data_budget = $(this).val(); // Mendapatkan nilai budget dari inputan
            month.push(data_month)
            budget.push(data_budget)
            // budgetData[month] = budget; // Menambahkan data budget ke objek budgetData
        });

        budgetData["month"] = month
        budgetData["budget"] = budget
        budgetData["budget_code"] = $(button).data('budget-code')
        // Melakukan permintaan AJAX untuk mengirim data ke server
        $.ajax({
            url: "<?= base_url($_SESSION['page']) ?>/createBudgetOnTop", // Ganti dengan URL server Anda
            method: "POST", // Jika ingin menggunakan metode POST
            data: budgetData,
            dataType: "json", // Tipe data yang diharapkan dari respons server (json dalam contoh ini)
            success: function(response) {
                // Fungsi ini akan dipanggil ketika respons dari server diterima dengan sukses
                // Tangani respons dari server jika perlu
                //console.log(response);
                if (response.success == true) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Data berhasil Disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        $('#divOntop').load("<?= base_url($_SESSION['page']) ?>/loadTableOnTop", {
                            budget_code: "<?= $budget_code ?>"
                        })
                        $('#modal-create-on-top').modal('hide')
                    })
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Gagal simpan data',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function(xhr, status, error) {
                // Fungsi ini akan dipanggil jika ada kesalahan saat melakukan permintaan AJAX
                // Tangani kesalahan di sini, jika perlu
                //console.error("Kesalahan saat mengirim data ke server:", error);
            }
        });
    }

    $(document).ready();

    function calculate_total_on_top() {
        var input_total_on_top = document.getElementById('total_on_top');
        var input_on_top = document.querySelectorAll('input.on_top');
        var total_on_top = 0;
        for (var i = 0; i < input_on_top.length; i++) {
            total_on_top += parseFloat(input_on_top[i].value.replace(/,/g, ''));
        }
        document.getElementById('total_on_top').value = total_on_top.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function edit_on_top() {
        var form = new FormData(document.getElementById('form_edit_on_top'));
        $.ajax({
            url: '<?= base_url($_SESSION['page'] . '/update_on_top') ?>',
            data: form,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {
                if (response.success == true) {
                    // return false;
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data berhasil Disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "<?= base_url($_SESSION['page'] . '/ShowDetailBudget/' . $budget_code); ?>";
                        loadingShow()
                    })
                } else if (response.total_on_top == 'lebih_kecil') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Total budget baru lebih kecil dari sebelumnya',
                    })
                    return false;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Data gagal disimpan!',
                    })
                }
            }
        });
    }
</script>