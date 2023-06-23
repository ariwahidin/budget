<?php 
    // var_dump($_SESSION);
?>
<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col col-md-12">
                <h4>Data Proposal
                    <a style="display: inline;" href="<?=base_url($_SESSION['page'])?>" class="btn btn-warning btn-sm pull-right">Back</a>
                </h4>
            </div>
            <!-- <div class="col col-md-6">
            </div> -->
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table-striped" id="table_proposal">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No Proposal</th>
                                    <th>Brand</th>
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
                                        <td><?= getBrandName($data->BrandCode) ?></td>
                                        <td><?= getActivityName($data->Activity) ?></td>
                                        <td><?= date('Y-m-d', strtotime($data->StartDatePeriode)) ?></td>
                                        <td><?= date('Y-m-d', strtotime($data->EndDatePeriode)) ?></td>
                                        <td><?= ucfirst($data->CreatedBy) ?></td>
                                        <td>
                                            <!-- <span class="label label-<?= $data->Status == 'approved' ? 'success' : ($data->Status == 'open' ? 'info' : 'warning') ?>"><?= ucfirst($data->Status) ?></span> -->
                                            <span class=""><?= ucfirst($data->Status) ?></span>
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
        $('#table_proposal').DataTable();
    });
</script>