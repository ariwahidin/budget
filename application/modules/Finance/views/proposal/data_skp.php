<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                        <strong>Data SKP</strong>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped" id="tableProposal" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor SKP</th>
                                    <th>Group Customer</th>
                                    <th>Service By</th>
                                    <th>Ket</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($skp->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->NoSKP ?></td>
                                        <td><?= $data->GroupCustomer ?></td>
                                        <td><?= $data->ServiceBy ?></td>
                                        <td><?= $data->Ket ?></td>
                                        <td>
                                            <button onclick="loadModalCustomerBySkp(this)" data-skp="<?= $data->NoSKP ?>" class="btn btn-primary btn-xs">Detail Customer</button>
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
<div id="loadModalCustomerBySkp"></div>
<script>
    $(document).ready(function() {
        $('#tableProposal').DataTable()
    })

    function loadModalCustomerBySkp(button) {
        let skp = $(button).data('skp')
        $('#loadModalCustomerBySkp').load("<?= base_url($_SESSION['page']) ?>/loadCustomerBySkp", {
            skp
        }, function() {
            $('#modal-customer').modal('show')
        })
    }
</script>