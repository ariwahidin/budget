<?php $this->view('header'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Proposal</h1>
    </section>
    <?php $this->load->view('alert') ?>
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
                                        <td><?= $data->BrandName ?></td>
                                        <td><?= ucfirst($data->CreatedBy) ?></td>
                                        <td>
                                            <span class="label label-<?= $data->Status == 'approved' ? 'success' : ($data->Status == 'open' ? 'info' : 'warning') ?>"><?= ucfirst($data->Status) ?></span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url($_SESSION['page']) . '/showProposalDetail/' . $data->Number ?>" class="btn btn-info btn-xs">Lihat</a>

                                            <button class="btn btn-primary btn-xs">Update</button>
                                            <a href="<?= base_url($_SESSION['page']) . '/deleteProposal/' . $data->Number ?>" class="btn btn-danger btn-xs">Delete</a>

                                            <a href="<?= base_url($_SESSION['page']) . '/cancelProposal/' . $data->Number ?>" class="btn btn-warning btn-xs">Cancel</a>
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
    });
</script>