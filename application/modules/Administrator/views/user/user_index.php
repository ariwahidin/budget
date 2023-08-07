<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Data User
                            <button onclick="loadModalUser()" style="display: inline;" class="btn btn-primary btn-sm pull-right">New User</button>
                        </h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped" id="tableUser">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>User Code</th>
                                    <th>Username</th>
                                    <th>Fullname</th>
                                    <th>Page</th>
                                    <th>Access_role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($user->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->user_code ?></td>
                                        <td><?= $data->username ?></td>
                                        <td><?= $data->fullname ?></td>
                                        <td><?= $data->page ?></td>
                                        <td><?= $data->access_role ?></td>
                                        <td>
                                            <button class="btn btn-primary btn-xs">
                                                Edit
                                            </button>
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
<div class="modal fade" id="modal-add-user">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Full Name</label>
                    <input type="text" class="form-control" id="fullname">
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" id="username">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="text" class="form-control" id="password">
                </div>
                <div class="form-group">
                    <label for="">Page</label>
                    <select name="" id="page" class="form-control">
                        <option value="">--Pilih--</option>
                        <?php foreach ($page->result() as $data) { ?>
                            <option value="<?= $data->page ?>"><?= $data->page ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button onclick="simpanUser()" type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tableUser').DataTable()
    })

    function loadModalUser() {
        $('#modal-add-user').modal('show')
    }

    function simpanUser() {
        let fullname = $('#fullname').val()
        let username = $('#username').val()
        let password = $('#password').val()
        let page = $('#page').val()

        if (fullname.trim() != "" && username.trim() != "" && password.trim() != "" && page.trim() != "") {
            $.ajax({
                url: "<?= base_url($_SESSION['page']) ?>/simpanUser",
                method: 'POST',
                data: {
                    fullname,
                    username,
                    password,
                    page
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(
                            window.location.href = "<?= base_url($_SESSION['page']) ?>/user"
                        )
                    } else {
                        Swal.fire(response.message)
                    }
                }
            })
        } else {
            Swal.fire('Input tidak boleh kosong')
        }
    }
</script>