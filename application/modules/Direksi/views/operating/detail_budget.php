<section class="content-wrapper">
    <section class="content-header">
        <h1>Budget Detail</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-primary">
                    <div class="box-header">
                        <strong>Brand : <?= $operating->row()->BrandName ?></strong>
                    </div>
                    <div class="box-body">

                        <table class="table table-bordered table-striped" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Month</th>
                                    <th>Principal Target</th>
                                    <th>Principal A&P</th>
                                    <th>PK Target</th>
                                    <th>PK A&P</th>
                                    <th>Operating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                $total_operating = 0;
                                foreach ($operating->result() as $data) {
                                    $total_operating += $data->OperatingBudget;
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= date('M Y', strtotime($data->Periode)) ?></td>
                                        <td><?= number_format($data->PrincipalTarget) ?></td>
                                        <td><?= number_format($data->AnpPrincipal) ?></td>
                                        <td><?= number_format($data->PKTargetIDR) ?></td>
                                        <td><?= number_format($data->PKAnpIDR) ?></td>
                                        <td><?= number_format($data->OperatingBudget) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><strong>Total</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong><?= number_format($total_operating) ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header">
                        <strong>Incoming Fund</strong>
                        <button onclick="loadModalIncomingFund()" class="btn btn-primary btn-xs pull-right">Create Incoming Fund</button>
                    </div>
                    <div class="box-body" id="box-fund">

                    </div>
                </div>
            </div>
            <div class="col col-md-4" id="divOntop">
            </div>
            <div class="col col-md-4" id="divOnTopResume">
            </div>
        </div>
    </section>
</section>
<div class="modal fade" id="modal_create_incoming_fund" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Create Incoming Fund</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Value</label>
                    <input type="number" class="form-control" id="value-fund" value="">
                </div>
                <div class="form-group">
                    <label for="">Note</label>
                    <input type="text" class="form-control" id="note-fund" value="">
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button onclick="simpanFund(this)" data-budget-code="<?= $budget_code ?>" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="modalLoadOnTop"></div>
<div id="modalLoadEditOnTop"></div>
<script>
    $(document).ready(function() {
        let budget_code = "<?= $budget_code ?>"
        $('#box-fund').load("<?= base_url($_SESSION['page']) ?>/loadTableFund", {
            budget_code
        })


        $('#divOntop').load("<?= base_url($_SESSION['page']) ?>/loadTableOnTop", {
            budget_code: "<?= $budget_code ?>"
        })

        $('#divOnTopResume').load("<?= base_url($_SESSION['page']) ?>/loadTableOnTopResume", {
            budget_code: "<?= $budget_code ?>"
        })
    })

    function loadModalEditOnTop(button) {
        const id = $(button).data('id')
        $('#modalLoadEditOnTop').load("<?= base_url($_SESSION['page']) ?>/loadModalEditOnTop", {
            id
        }, function() {
            $('#modal-edit-on-top').modal('show')
        })
    }

    function loadModalIncomingFund() {
        $('#modal_create_incoming_fund').modal('show')
    }

    function simpanFund(button) {
        let budget_code = $(button).data('budget-code')
        let value = $('#value-fund').val()
        let note = $('#note-fund').val()
        if (value.trim() != "") {
            $.ajax({
                url: "<?= base_url($_SESSION['page']) ?>/simpanFund",
                method: "POST",
                data: {
                    budget_code,
                    value,
                    note
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil simpan data',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            $('#box-fund').load("<?= base_url($_SESSION['page']) ?>/loadTableFund", {
                                budget_code
                            })
                            $('#modal_create_incoming_fund').modal('hide')
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal simpan data',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
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
                            $('#divOnTopResume').load("<?= base_url($_SESSION['page']) ?>/loadTableOnTopResume", {
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
</script>