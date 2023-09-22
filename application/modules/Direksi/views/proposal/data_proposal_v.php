<?php
// var_dump($_SESSION);
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col col-md-12">
                <h4>Data Proposal
                    <a style="display: inline;" href="<?= base_url($_SESSION['page']) ?>" class="btn btn-warning btn-sm pull-right">Back</a>
                    <form style="display: inline;" action="<?= base_url($_SESSION['page'] . '/exportResumeProposalToExcel') ?>" method="POST">
                        <button id="unduhExcel" style="margin-right:5px;" type="submit" class="btn btn-success btn-sm pull-right">Export to excel</button>
                    </form>
                </h4>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped" id="table_proposal">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No Proposal</th>
                                    <th>Brand</th>
                                    <th>Activity</th>
                                    <th>Start Periode</th>
                                    <th>End Periode</th>
                                    <th>Costing</th>
                                    <th>Pic</th>
                                    <th>Created Date</th>
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
                                        <td><?= getBrandName($data->BrandCode) ?></td>
                                        <td><?= getActivityName($data->Activity) ?></td>
                                        <td><?= date('d M Y', strtotime($data->StartDatePeriode)) ?></td>
                                        <td><?= date('d M Y', strtotime($data->EndDatePeriode)) ?></td>
                                        <td style="text-align: right;"><?= number_format($data->TotalCosting) ?></td>
                                        <td><?= ucfirst($data->CreatedBy) ?></td>
                                        <td><?= date('d M Y', strtotime($data->CreatedDate)) ?></td>
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
                                            <?php if ($_SESSION['access_role'] == 'administrator') { ?>
                                                <button class="btn btn-primary btn-xs">Update</button>
                                                <a href="<?= base_url($_SESSION['page']) . '/deleteProposal/' . $data->Number ?>" class="btn btn-danger btn-xs">Delete</button>
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
        $('#table_proposal').DataTable({resposive : true});

        $('#btnReportDetail').on('click', function() {
            window.location.href = "<?= base_url($_SESSION['page']) . '/reportDetail' ?>"
        })
    });

    $('#unduhExcel').on('click', function() {
        loadingShow()
        console.log("Starting...");
        setTimeout(loadingHide, 9000); // Menjalankan delayedFunction setelah 2000 milidetik (2 detik)
        console.log("End.");
        this.addEventListener('DOMContentLoaded', delayedFunction())
    })

    function delayedFunction() {
        console.log("Delayed function executed!");
    }
</script>