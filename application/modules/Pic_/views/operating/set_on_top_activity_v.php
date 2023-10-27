<?php
// var_dump($brand);
// var_dump($budget_code);
// var_dump($operating_header->result());
// var_dump($operating->row()->Valas);
// die;
?>
<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <button onclick="simpan_on_top_activity()" class="btn btn-primary pull-right">Simpan</button>
        <h4>Breakdown Activity On Top</h4>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Activity</th>
                                    <th>Budget On top (<span id="span_total_input">0</span>%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="form_activity">
                                    <input type="hidden" name="budget_code" value="<?= $budget_code ?>">
                                    <?php $no = 1;
                                    foreach ($activity->result() as $data) { ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= getActivityName($data->id) ?></td>
                                            <td>
                                                <input name="budget_code_activity[]" type="hidden" value="<?= $budget_code . '/' . $data->id ?>">
                                                <input name="activity_id[]" type="hidden" value="<?= $data->id ?>">
                                                <input name="input_percent_activity[]" onkeyup="reset_to_zero(this);calculate_total_input();convertFloat(this)" class="input_on_top form-control" type="number" min="0" value="0">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->view('footer') ?>
<script>
    function reset_to_zero(elem) {
        if (elem.value == '') {
            elem.value = 0;
        }
    }

    function calculate_total_input() {
        var input_on_top = document.querySelectorAll('input.input_on_top');
        var span_total_input = document.getElementById('span_total_input');
        var total_input = 0;
        for (var i = 0; i < input_on_top.length; i++) {
            total_input += parseFloat(input_on_top[i].value);
        }
        span_total_input.innerText = total_input;
    }

    function convertFloat(elem) {
        var inputan = elem.value;
        elem.value = parseFloat(inputan)
    }

    function simpan_on_top_activity() {
        var form = document.getElementById('form_activity');
        var formData = new FormData(form);
        var total_input = parseFloat(document.getElementById('span_total_input').innerText);
        if (total_input < 100) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: 'Total input kurang dari 100%',
            })
            return false;
        }
        if (total_input > 100) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: 'Total input lebih dari 100%',
            })
            return false;
        }
        $.ajax({
            url: '<?= base_url($_SESSION['page'] . '/simpan_on_top_activity') ?>',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {
                if (response.success == true) {
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