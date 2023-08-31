<div class="content-wrapper">
    <section class="content">
        <h4 class="title">
            <strong>
                Change User Password
            </strong>
        </h4>

        <div class="row">
            <div class="col-md-4">
                <?php $this->view('alert') ?>
                <div class="box box-primary">
                    <div class="box-body">
                        <form action="<?= base_url($_SESSION['page'] . '/changePassword') ?>" method="POST" id="formPassword">
                            <div class="form-group">
                                <label for="">New Password</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword">
                            </div>
                            <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                            </div>
                        </form>
                        <button id="btnPasswordSave" class="btn btn-primary pull-right">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $('#btnPasswordSave').on('click', function() {
            let newPassword = $('#newPassword').val()
            let confirmPassword = $('#confirmPassword').val()
            let form = $('#formPassword')
            if (newPassword == "") {
                Swal.fire(
                    'New password tidak boleh kosong',
                    '',
                    'warning'
                )
            } else if (confirmPassword == "") {
                Swal.fire(
                    'Confirm password tidak boleh kosong',
                    '',
                    'warning'
                )
            } else if (newPassword != confirmPassword) {
                Swal.fire(
                    'Password tidak cocok',
                    '',
                    'warning'
                )
            } else if (newPassword.length < 3) {
                Swal.fire(
                    'Password minimal 3 karakter',
                    '',
                    'warning'
                )
            } else {
                form.submit()
            }
        })
    })
</script>