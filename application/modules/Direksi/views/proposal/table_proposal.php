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
                <td style="width: 12%;">
                    <a href="<?= base_url($_SESSION['page']) . '/showProposalDetail/' . $data->Number ?>" class="btn btn-info btn-xs">Lihat</a>
                    <a href="<?= base_url($_SESSION['page']) . '/exportProposalToPdf/' . $data->Number ?>" class="btn btn-danger btn-xs">Pdf</a>
                    <?php if ($data->Status == 'open') { ?>
                        <button onclick="cancelProposal(this)" data-proposal-number="<?= $data->Number ?>" class="btn btn-warning btn-xs">Cancel</button>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#table_proposal').DataTable({resposive : true});
    });
</script>