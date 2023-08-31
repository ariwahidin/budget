<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                        <h4>Data User Direksi
                        </h4>
                    </div>
                    <div class="box-body" id="bodyTableDireksi">
                        <?php $this->load->view('user/table_user_direksi') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-edit-level">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Level Direksi</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="input-id-user">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($level->result() as $data) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->code ?></td>
                                <td>
                                    <button onclick="saveLevel(this)" data-id="" data-code="<?= $data->code ?>" class="btn btn-primary btn-xs">select</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function loadModalEditLevel(button) {
        var id = $(button).data('id')
        $('#input-id-user').val(id)
        $('#modal-edit-level').modal('show')
    }

    function saveLevel(button) {
        var id = $('#input-id-user').val()
        var code = $(button).data('code')
        console.log(id)
        console.log(code)

        $.ajax({
            url: "<?= base_url($_SESSION['page']) ?>/simpanLevelDireksi",
            method: "POST",
            data: {
                id,
                code
            },
            dataType: "JSON",
            success: function(response) {
                if (response.success == true) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        $('#bodyTableDireksi').load("<?= base_url($_SESSION['page']) ?>/loadTableUserDireksi")
                        $('#modal-edit-level').modal('hide')
                    })
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: response.message,
                    })
                }
            }
        })
    }

    // function simpanUser() {
    //     let fullname = $('#fullname').val()
    //     let username = $('#username').val()
    //     let password = $('#password').val()
    //     let page = $('#page').val()

    //     if (fullname.trim() != "" && username.trim() != "" && password.trim() != "" && page.trim() != "") {
    //         $.ajax({
    //             url: "<?= base_url($_SESSION['page']) ?>/simpanUser",
    //             method: 'POST',
    //             data: {
    //                 fullname,
    //                 username,
    //                 password,
    //                 page
    //             },
    //             dataType: "JSON",
    //             success: function(response) {
    //                 if (response.success == true) {
    //                     Swal.fire({
    //                         position: 'top-end',
    //                         icon: 'success',
    //                         title: response.message,
    //                         showConfirmButton: false,
    //                         timer: 1500
    //                     }).then(
    //                         window.location.href = "<?= base_url($_SESSION['page']) ?>/user"
    //                     )
    //                 } else {
    //                     Swal.fire(response.message)
    //                 }
    //             }
    //         })
    //     } else {
    //         Swal.fire('Input tidak boleh kosong')
    //     }
    // }
</script>