<div class="modal fade" id="modal-image-skp">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Gambar SKP</h4>
            </div>
            <div class="modal-body">
                <?php
                // var_dump($image);
                $gambarPath = FCPATH . $image;
                if (!is_null($image)) {
                    if (file_exists($gambarPath)) { ?>
                        <img class="img-responsive pad" src="<?= base_url($image) ?>" alt="Photo">
                    <?php } else {
                        echo "<p>Tidak ada SKP</p>";
                    }
                } else { ?>
                    <p>Tidak ada SKP</p>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>