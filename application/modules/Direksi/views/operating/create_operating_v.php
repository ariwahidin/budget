<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Create Operating</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                        <form action="<?= base_url($_SESSION['page'] . '/createOperating2') ?>" id="formCreateOperating" method="post">
                            <div class="box-body">
                                <table class="table table-responsive">
                                    <tr>
                                        <td><label for="">Brand:</label></td>
                                        <td>
                                            <select class="form-control select2" name="brand" id="brand" required>
                                                <option value="">--Pilih--</option>
                                                <?php foreach ($brand->result() as $data) { ?>
                                                    <option value="<?= $data->BrandCode ?>"><?= $data->BrandName ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="start">Start month:</label></td>
                                        <td>
                                            <input type="month" class="form-control" id="start_month" name="start_month" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="start">End month:</label></td>
                                        <td>
                                            <input type="month" class="form-control" id="end_month" name="end_month" required>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">
                                Next
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->view('footer'); ?>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })

    function createOperating() {
        var formData = new FormData(document.getElementById("formCreateOperating"));
        // $.ajax({
        //     url: '<?= base_url($_SESSION['page'] . '/createOperating2') ?>',
        //     processData: false,
        //     contentType: false,
        //     type: 'POST',
        //     data: formData,
        //     dataType: 'JSON',
        // });
    }
</script>