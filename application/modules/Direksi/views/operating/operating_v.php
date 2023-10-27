<!-- <?php var_dump($operating->result()) ?> -->
<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Budget</h4>
                    </div>
                    <div class="box-body">
                        <form action="<?= base_url($_SESSION['page']) ?>/loadDetailBudget" method="POST" id="formDetailBudget">
                            <input type="hidden" id="budget_code" name="budget_code">
                        </form>
                        <table id="tabel1" class="table table-bordered table-responsive table_operating" style="font-size:12px">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Brand</th>
                                    <th>Periode</th>
                                    <th>Valas</th>
                                    <th>Exchange Rate</th>
                                    <th>Actual A&P</th>
                                    <th>Target Principal</th>
                                    <th>A&P Principal</th>
                                    <th>Target PK</th>
                                    <th>A&P PK</th>
                                    <th>Operating</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($operating->result() as $op) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $op->BrandName ?></td>
                                        <td><?= date('M-Y', strtotime($op->StartPeriode)) . ' s/d ' . date('M-Y', strtotime($op->EndPeriode)) ?></td>
                                        <td><?= strtoupper($op->Valas) ?></td>
                                        <td><?= number_format($op->ExchangeRate) ?></td>
                                        <td><?= number_format($op->ActualAnp) ?></td>
                                        <td><?= number_format($op->PrincipalTarget) ?></td>
                                        <td><?= number_format($op->TargetAnp) ?></td>
                                        <td><?= number_format($op->PKTarget) ?></td>
                                        <td><?= number_format($op->PKAnp) ?></td>
                                        <td><?= number_format($op->OperatingBudget) ?></td>
                                        <td>
                                            <button onclick="loadDetailBudget(this)" data-budget-code='<?= $op->BudgetCode ?>' class="btn btn-primary btn-xs">Detail</button>
                                            <!-- <a onclick="loading()" href="<?= base_url($_SESSION['page'] . '/ShowDetailBudget/' . $op->BudgetCode) ?>" class="btn btn-success btn-xs">Tracking Budget</a>
                                            <?php if (statusOperatingActivity($op->BudgetCode) == 'not complete') { ?>
                                                <a href="<?= base_url($_SESSION['page'] . '/lihatOperatingActivity/' . $op->BudgetCode) ?>" class="btn btn-info btn-xs">Breakdown Activity</a>
                                            <?php } ?> -->

                                            <?php if ($op->NewOperating > 0) { ?>
                                                <button class="btn btn-xs btn-success" onclick="showModalApproveOperating(this)" data-budgetcode="<?= $op->BudgetCode ?>">new operating</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-approve-operating">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Approve operating</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">New operating</label>
                    <div id="bodyApproveOperating">
                    </div>
                    <input type="hidden" class="form-control" id="apprBudgetCode">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" onclick="prosesApproveExtendOperating()" class="btn btn-primary">Approve</button>
            </div>
        </div>
    </div>
</div>

<?php $this->view('footer') ?>
<script>
    $('#tabel1').DataTable({
        responsive: true
    });

    function loading() {
        div_loading = document.getElementById('muncul_loading');
        div_loading.classList.add('loading');
    }

    function loadDetailBudget(button) {
        let budgetCode = $(button).data('budget-code')
        $('#budget_code').val(budgetCode)
        $('#formDetailBudget').submit()
    }

    let prosesApproveExtendOperating = () => {

        let budgetCode = $('#apprBudgetCode').val();
        console.log(budgetCode);
        $.ajax({
            url: "<?= base_url($_SESSION['page'] . '/approveNewOperating') ?>",
            method: 'POST',
            data: {
                budgetcode: budgetCode
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success == true) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Data berhasil disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = "<?= base_url($_SESSION['page'] . '/showOperating') ?>";
                    })
                } else {
                    Swal.fire(
                        'Error',
                        'Gagal simpan data',
                        'error'
                    )
                }
            }
        })
    };

    function showModalApproveOperating(elem) {
        let budgetcode = $(elem).data('budgetcode');
        // alert(budgetcode);

        $.ajax({
            url: "<?= base_url($_SESSION['page'] . '/getNewOperatingToApprove') ?>",
            method: 'POST',
            data: {
                budgetcode
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success == true) {
                    let bodyOperating = $('#bodyApproveOperating')
                    bodyOperating.html('')
                    let data = response.data;
                    data.forEach(function(item) {
                        bodyOperating.append(`<input style="margin-bottom:3px" type="text" class="form-control" id="operatingAmount" value="${formatUang(item.OperatingAmount)}" readonly>`)
                    });
                    $('#apprBudgetCode').val(budgetcode)
                    $('#modal-approve-operating').modal('show')
                }
            }
        })

    }

    function formatUang(number) {
        // Menggunakan toLocaleString() dengan pengaturan bahasa "id-ID" (Indonesia)
        return number.toLocaleString("id-ID");
    }
</script>