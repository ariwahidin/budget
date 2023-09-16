<?php
// var_dump($_SESSION);
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Proposal</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <form style="display: inline;" action="<?= base_url($_SESSION['page'] . '/exportResumeProposalToExcel') ?>" method="POST">
                            <button type="submit" class="btn btn-success btn-sm pull-right">Export to excel</button>
                        </form>
                        <a href="<?= base_url($_SESSION['page']) ?>/show_create_form" class="btn btn-primary btn-sm pull-right" style="margin-right: 5px;">Create new proposal</a>
                        <!-- <button class="btn-success btn-sm pull-right" data-toggle="modal" data-target="#modal-default">Export excel</button> -->
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped" id="table_proposal">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No Proposal</th>
                                    <th>Ref Code</th>
                                    <th>Brand</th>
                                    <th>Activity</th>
                                    <th>Start Periode</th>
                                    <th>End Periode</th>
                                    <th>Pic</th>
                                    <th>Status</th>
                                    <th>Management</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($proposal->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->Number ?></td>
                                        <td><?= $data->NoRef ?></td>
                                        <td><?= getBrandName($data->BrandCode) ?></td>
                                        <td><?= getActivityName($data->Activity) ?></td>
                                        <td><?= date('d M Y', strtotime($data->StartDatePeriode)) ?></td>
                                        <td><?= date('d M Y', strtotime($data->EndDatePeriode)) ?></td>
                                        <td><?= ucfirst($data->CreatedBy) ?></td>
                                        <td>
                                            <span class=""><?= ucfirst($data->Status) ?></span>
                                        </td>
                                        <td>
                                            <?php foreach (getApprovedBy($data->Number)->result() as $a) { ?>
                                                <?php if ($a->is_approve == 'y') { ?>
                                                    <span class="label label-success"><i class="fa fa-check"></i><?= ucfirst($a->fullname) . " " . date('d/m/y', strtotime($a->created_at)) ?></span><br>
                                                <?php } else { ?>
                                                    <span class="label label-danger"><i class="fa fa-close"></i><?= ucfirst($a->fullname) . " " . date('d/m/y', strtotime($a->created_at)) ?></span><br>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url($_SESSION['page']) . '/showProposalDetail/' . $data->Number ?>" class="btn btn-info btn-xs">Lihat</a>
                                            <?php if ($data->Status == 'open') { ?>
                                                <button onclick="cancelProposal(this)" data-proposal-number="<?= $data->Number ?>" class="btn btn-warning btn-xs">Cancel</button>
                                            <?php } ?>
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
<?php $this->view('footer'); ?>



<script>
    $(document).ready(function() {
        $('#table_proposal').DataTable();
    });

    function cancelProposal(button) {
        const proposal_number = $(button).data('proposal-number')
        Swal.fire({
            title: 'Yakin cancel proposal?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url($_SESSION['page'] . '/cancelProposal') ?>",
                    method: "POST",
                    data: {
                        proposal_number
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success == true) {
                            // Swal.fire('Saved!', '', 'success')
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Cancel proposal berhasil',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = "<?= base_url($_SESSION['page']) ?>/showProposal"
                            })
                        } else {
                            Swal.fire('Gagal cancel proposal', '', 'error')
                        }
                    }
                })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
</script>