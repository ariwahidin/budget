<div class="modal fade" id="modal-tambahskpb">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Input SKP</h4>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <div class="form-group">
                    <table class="table table-responsive table-bordered" style="font-size: 12px;">
                        <?php  foreach ($group->result() as $data) { ?>
                            <tr>
                                <td><?= $data->SubGroupName ?></td>
                                <td>
                                    <input type="hidden" class="form-control data-group" value="<?= $data->GroupCode ?>">
                                    <input type="hidden" class="form-control data-sub-group" value="<?= $data->SubGroupCode ?>">
                                    <input type="hidden" class="form-control data-id" value="<?= $data->id ?>">
                                    <input type="text" class="form-control input-sm data-skp" placeholder="Nomor SKP" value="<?= $data->NoSKP ?>">
                                </td>
                                <td><input type="text" class="form-control input-sm value-skp rupiah" placeholder="Value SKP" value="<?= rupiah($data->Valueskp) ?>"></td>

                                <td><input type="text" class="form-control input-sm data-ket" placeholder="Keterangan" value="<?= $data->Ket ?>"></td>
                                <td>
                                    <input onchange="compressImage(this)" value="<?= $data->Img ?>" type="file" id="<?= "img_ori_" . $data->SubGroupCode ?>" data-sub-group="<?= $data->SubGroupCode ?>" class="form-control input-sm" accept="image/*">
                                    <input type="hidden" class="img-comp" id="<?= "img_comp_" . $data->SubGroupCode ?>" name="gambar_kompres" required>
                                </td>
                                <td>
                                    <button onclick="lihatGambar(this)" data-id="<?= $data->id ?>" class="btn btn-primary btn-xs">Lihat gambar</button>
                                </td>
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

<div id="modalGambarSKP"></div>
<script>
    rupiah();
    function simpanSKP(button) {
        let number = $(button).data('number')
        alert('test ' + number)
    }

    function compressImage(input) {

        var sub_group = $(input).data('sub-group')
        var input_id = 'img_ori_' + sub_group
        var fileInput = document.getElementById(input_id);
        var file = fileInput.files[0];
        var inputImageCompres = document.getElementById('img_comp_' + sub_group)

        if (!file) {
            inputImageCompres.value = "";
        } else {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = new Image();
                img.src = e.target.result;

                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');

                    // Mengatur ukuran canvas sesuai kebutuhan
                    var maxWidth = 800;
                    var maxHeight = 600;
                    var width = img.width;
                    var height = img.height;

                    if (width > height) {
                        if (width > maxWidth) {
                            height *= maxWidth / width;
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width *= maxHeight / height;
                            height = maxHeight;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;

                    // Menggambar gambar pada canvas dengan ukuran yang sudah ditentukan
                    ctx.drawImage(img, 0, 0, width, height);

                    // Mengompres gambar menjadi base64
                    var compressedDataUrl = canvas.toDataURL('image/jpeg', 0.7); // Menggunakan format JPEG dengan kualitas 0.7

                    // Menambahkan data gambar yang sudah dikompres ke input tersembunyi sebelum submit
                    inputImageCompres.value = compressedDataUrl;

                    // Submit form
                    // document.getElementById('formIssue').submit();
                }
            }
            reader.readAsDataURL(file);
        }
    }

    document.getElementById("sendButton").addEventListener("click", function() {
        var action = "<?= $action ?>";
        var number = "<?= $number ?>";
        var dataId = document.getElementsByClassName("data-id");
        var dataGroup = document.getElementsByClassName("data-group");
        var dataSubGroup = document.getElementsByClassName("data-sub-group");
        var dataSKP = document.getElementsByClassName("data-skp");
        
        var valueSKP = document.getElementsByClassName("value-skp");
        var dataKET = document.getElementsByClassName("data-ket");
        var dataImg = document.getElementsByClassName("img-comp");
        var arrayId = [];
        var arrayGroup = [];
        var arraySubGroup = [];
        var arraySKP = [];
        var arrayValue = [];
        var arrayVals = [];
        var arrayKET = [];
        var arrayImg = [];

        for (var i = 0; i < dataSKP.length; i++) {
            arrayId.push(dataId[i].value)
            arrayGroup.push(dataGroup[i].value);
            arraySubGroup.push(dataSubGroup[i].value);
            arraySKP.push(dataSKP[i].value);
            arrayKET.push(dataKET[i].value);
            arrayValue.push(valueSKP[i].value);
            arrayImg.push(dataImg[i].value);
        }

        // Kirim data ke server (contoh menggunakan fetch API)
        fetch("<?= base_url($_SESSION['page']) ?>/simpanskpb", {
                method: "POST",
                body: JSON.stringify({
                    action: action,
                    number: number,
                    id: arrayId,
                    group: arrayGroup,
                    sub_group: arraySubGroup,
                    skp: arraySKP,
                    valuskp: arrayValue,
                    ket: arrayKET,
                    img: arrayImg
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
                        $('#modal-input-skp').modal('hide')
                    })
                } else {
                    Swal.fire(data.message)
                }
            })
            .catch(error => {
                console.error("Terjadi kesalahan:", error);
            });
    });
    
    
    function lihatGambar(button) {

        let id = $(button).data('id');
        console.log(id);
        $('#modalGambarSKP').load("<?= base_url($_SESSION['page']) ?>/loadImageSkp", {
            id
        }, function() {
            $('#modal-image-skp').modal('show')
        });
    };
</script>