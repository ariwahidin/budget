<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header">
                <strong>Data Proposal</strong>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tableProposal" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Proposal Number</th>
                            <th>Created Date</th>
                            <th>Brand</th>
                            <th>Start Periode</th>
                            <th>End Periode</th>
                            <th>Activity</th>
                            <th>Total Costing</th>
                            <th>Skp</th>
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
                                <td><?= date('d M Y', strtotime($data->CreatedDate)) ?></td>
                                <td><?= $data->BrandName ?></td>
                                <td><?= date('d M Y', strtotime($data->StartDatePeriode)) ?></td>
                                <td><?= date('d M Y', strtotime($data->EndDatePeriode)) ?></td>
                                <td><?= $data->ActivityName ?></td>
                                <td><?= number_format($data->TotalCosting) ?></td>
                                <td><?= $data->jml_skp ?></td>
                                <td><?= $data->Status ?></td>
                                <td><a href="<?= base_url($_SESSION['page']) ?>/detailProposal/<?= $data->Number ?>" class="btn btn-primary btn-xs">Detail</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $('#tableProposal').DataTable()
    })
</script>