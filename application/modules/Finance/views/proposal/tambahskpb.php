<div class="modal fade" id="modal-tambahskpb">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Input SKP</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <table class="table table-responsive table-bordered" style="font-size: 12px;">
                        <?php foreach ($group->result() as $data) { ?>
                            <tr>
                                <td><?= $data->GroupName ?></td>

                                <td>
                                    <input type="hidden" class="form-control data-group" value="<?= $data->GroupCode ?>">
                                    <input type="hidden" class="form-control data-id" value="<?= $data->id ?>">
                                    <input type="text" class="form-control input-sm data-skp" placeholder="Nomor SKP" value="<?= $data->NoSKP ?>">
                                </td>
                                <td><input type="text" class="form-control input-sm value-skp rupiah" placeholder="Value SKP" value="<?= $data->Valueskp ?>"></td>
                            </tr>
                            <tr>    
                                <td colspan="3"><input type="text" class="form-control input-sm data-ket" placeholder="Keterangan" value="<?= $data->Ket ?>"></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button id="sendButton" data-number="<?= $number ?>" type="button" class="btn btn-primary"><?= ucfirst($action) ?></button> 
            </div>
        </div>
    </div>
</div>
<script>
    
rupiah();
    function simpanSKP(button) {
        let number = $(button).data('number')
        alert('test ' + number)
    }

    document.getElementById("sendButton").addEventListener("click", function() {
        var action = "<?= $action ?>";
        var number = "<?= $number ?>";
        var dataId = document.getElementsByClassName("data-id");
        var dataGroup = document.getElementsByClassName("data-group");
        var dataSKP = document.getElementsByClassName("data-skp");
        var valueSKP = document.getElementsByClassName("value-skp");
        var dataKET = document.getElementsByClassName("data-ket");
        var arrayId = [];
        var arrayGroup = [];
        var arraySKP = [];
        var arrayVals = [];
        var arrayKET = [];

        for (var i = 0; i < dataSKP.length; i++) {
            arrayId.push(dataId[i].value)
            arrayGroup.push(dataGroup[i].value);
            arraySKP.push(dataSKP[i].value);
            arrayVals.push(valueSKP[i].value);
            arrayKET.push(dataKET[i].value);
        }

        // Kirim data ke server (contoh menggunakan fetch API)
        fetch("<?= base_url($_SESSION['page']) ?>/simpanskpb", {
                method: "POST",
                body: JSON.stringify({
                    action: action,
                    number: number,
                    id: arrayId,
                    group: arrayGroup,
                    skp: arraySKP,
                    valueskp: arrayVals,
                    ket: arrayKET,
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                // Lakukan sesuatu dengan respons dari server (opsional)
                if (data.status == 'success') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        $('#modal-tambahskpb').modal('hide')
                    })
                } else {
                    Swal.fire(data.message)
                }
            })
            .catch(error => {
                console.error("Terjadi kesalahan:", error);
            });
    });
</script>