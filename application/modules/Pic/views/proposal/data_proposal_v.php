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
                        <button class="btn-info btn-sm pull-right" data-toggle="modal" data-target="#modal-default">Export</button>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-bordered table-striped" id="table_proposal">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No Proposal</th>
                                    <th>Ref Code</th>
                                    <th>Brand</th>
                                    <!-- <th>Group Customer</th> -->
                                    <th>Activity</th>
                                    <th>Start Periode</th>
                                    <th>End Periode</th>
                                    <th>Pic</th>
                                    <th>Status</th>
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
                                        <!-- <td></td> -->
                                        <td><?= getActivityName($data->Activity) ?></td>
                                        <td><?= date('d M Y', strtotime($data->StartDatePeriode)) ?></td>
                                        <td><?= date('d M Y', strtotime($data->EndDatePeriode)) ?></td>
                                        <td><?= ucfirst($data->CreatedBy) ?></td>
                                        <td>
                                            <!-- <span class="label label-<?= $data->Status == 'approved' ? 'success' : ($data->Status == 'open' ? 'info' : 'warning') ?>"><?= ucfirst($data->Status) ?></span> -->
                                            <span class=""><?= ucfirst($data->Status) ?></span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url($_SESSION['page']) . '/showProposalDetail/' . $data->Number ?>" class="btn btn-info btn-xs">Lihat</a>
                                            <!-- <button class="btn btn-primary btn-xs">Update</button> -->
                                            <!-- <a href="<?= base_url($_SESSION['page']) . '/deleteProposal/' . $data->Number ?>" class="btn btn-danger btn-xs">Delete</button> -->
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Export</h4>
            </div>
            <form action="<?= base_url($_SESSION['page'] . '/exportResumeProposalToExcel') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Brand : </label>
                        <select class="form-control" name="brandCode" required>
                            <option value=""></option>
                            <?php foreach ($brand->result() as $data) { ?>
                                <option value="<?= $data->BrandCode ?>"><?= $data->BrandName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Download</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->view('footer'); ?>



<script>
    $(document).ready(function() {
        $('#table_proposal').DataTable();
    });
</script>