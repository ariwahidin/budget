<?php $this->load->view('header') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <?php $this->view('alert') ?>
                <div class="box">
                    <div class="box-header">
                        <h4>
                            Data Pic Brand
                            <button class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#modal-default">Add Pic Brand</button>
                        </h4>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="table_pic">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pic Code</th>
                                    <th>Pic Name</th>
                                    <th>Brand</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($pic->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->UserCode ?></td>
                                        <td><?= $data->Pic ?></td>
                                        <td><?= $data->BrandName ?></td>
                                        <td>
                                            <button class="btn btn-primary btn-xs">Edit</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add Pic Brand</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url() . $_SESSION['page'] . '/addPicBrand' ?>" method="POST" id="formAddPicBrand">
                            <div class="form-group">
                                <label for="">Pic :</label>
                                <select style="width: 100%;" name="pic" id="pic" class="form-control inputan">
                                    <option value="">--Pilih Pic--</option>
                                    <?php foreach ($user->result() as $data) { ?>
                                        <option value="<?= $data->user_code ?>"><?= $data->fullname ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Brand :</label>
                                <select style="width: 100%;" name="brand" id="brand" class="form-control inputan">
                                    <option value="">--Pilih Brand--</option>
                                    <?php foreach ($brand->result() as $data) { ?>
                                        <option value="<?= $data->BrandCode ?>"><?= $data->BrandName ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" id="btnSave" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view('footer') ?>
<script>
    $(document).ready(function() {
        $('#table_pic').DataTable()
        $('#brand').select2()
        $('#pic').select2()
        $('#btnSave').on('click', function() {
            var form = $('#formAddPicBrand')
            var isEmpty = false;

            $('.inputan').each(function() {
                var inputValue = $(this).val().trim()
                if (inputValue == '') {
                    Swal.fire(
                        'Inputan tidak boleh kosong',
                        '',
                        'warning'
                    )
                    isEmpty = true
                    return false
                }
            })

            if (isEmpty == false) {
                form.submit()
            }

        })
    })
</script>