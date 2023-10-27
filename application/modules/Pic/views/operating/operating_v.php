<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <!-- <button onclick="testAlert()" class="btn btn-primary pull-right">Test</button> -->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Budget</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table-striped table_operating" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <!-- <th>Brand Code</th> -->
                                    <!-- <th>Budget Code</th> -->
                                    <th>Brand</th>
                                    <th>Periode</th>
                                    <th>Principal Target</th>
                                    <th>Principal A&P</th>
                                    <th>PK Target</th>
                                    <th>PK A&P</th>
                                    <th>Operating</th>
                                    <th style="display:none">Actual Purchase</th>
                                    <th style="display:none">Actual A&P</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($operating->result() as $op) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <!-- <td><?= $op->BrandCode ?></td> -->
                                        <!-- <td><?= $op->BudgetCode ?></td> -->
                                        <td><?= $op->BrandName ?></td>
                                        <td><?= date('M-Y', strtotime($op->StartPeriode)) . ' s/d ' . date('M-Y', strtotime($op->EndPeriode)) ?></td>
                                        <td><?= number_format($op->PrincipalTarget) ?></td>
                                        <td><?= number_format($op->TargetAnp) ?></td>
                                        <td><?= number_format($op->TotalPKTargetIDR) ?></td>
                                        <td><?= number_format($op->TotalPKAnpIDR) ?></td>
                                        <td><?= number_format($op->OperatingBudget) ?></td>
                                        <td style="display:none"><?= number_format(getActualPurchase($op->BrandCode, $op->StartPeriode, $op->EndPeriode)) ?></td>
                                        <td style="display:none"><?= number_format(getActualPurchase($op->BrandCode, $op->StartPeriode, $op->EndPeriode) * (10 / 100)) ?></td>
                                        <td><?= statusOperatingActivity($op->BudgetCode) ?></td>
                                        <td>
                                            <a onclick="loading()" href="<?= base_url($_SESSION['page'] . '/ShowDetailBudget/' . $op->BudgetCode) ?>" class="btn btn-success btn-xs">Detail</a>
                                            <?php if (statusOperatingActivity($op->BudgetCode) == 'not complete') { ?>
                                                <a href="<?= base_url($_SESSION['page'] . '/lihatOperatingActivity/' . $op->BudgetCode) ?>" class="btn btn-info btn-xs">Breakdown Activity</a>
                                            <?php } ?>
                                            <button onclick="showModalAddOperating(this)" data-budgetcode="<?= $op->BudgetCode ?>" data-toggle="modal" data-target="#modal-add-operating" class="btn btn-xs btn-primary">Add operating</button>
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

<div class="modal fade" id="modal-add-operating">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Extend Operating</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Operating Amount</label>
                    <input type="number" class="form-control" id="operatingAmount">
                    <input type="hidden" class="form-control" id="budgetCode">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" onclick="prosesSimpanExtendOperating()" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?php $this->view('footer') ?>
<script>
    $('.table_operating').DataTable({
        resposive: true
    });

    function loading() {
        div_loading = document.getElementById('muncul_loading');
        div_loading.classList.add('loading');
    }

    function testAlert() {
        Swal.fire(
            'Good job!',
            'You clicked the button!',
            'success'
        )
    }

    function showModalAddOperating(elem) {
        let budgetCode = $(elem).data('budgetcode');
        $('#budgetCode').val(budgetCode)
    }

    function prosesSimpanExtendOperating() {
        let budgetCode = $('#budgetCode').val();
        let amountOperating = $('#operatingAmount').val();

        if (budgetCode.trim() != '') {
            $.ajax({
                url: "<?= base_url($_SESSION['page'] . '/createExtendOperating') ?>",
                method: "POST",
                data: {
                    amountOperating,
                    budgetCode
                },
                dataType: "JSON",
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
        }
    }
</script>