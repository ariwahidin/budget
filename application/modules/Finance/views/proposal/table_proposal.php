<table class="table table-hover text-nowrap table-bordered table-striped table-responsive geserkk" id="tableProposal" style="font-size: 12px;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Proposal Number</th>
            <th>Brand</th>
            <th>Group</th>
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
                <td><?= $data->BrandName ?></td>
                <td><?= $data->GroupName ?></td>
                <td><?= date('d M Y', strtotime($data->StartDatePeriode)) ?></td>
                <td><?= date('d M Y', strtotime($data->EndDatePeriode)) ?></td>
                <td><?= $data->ActivityName ?></td>
                <td><?= number_format($data->TotalCosting) ?></td>
                <td><?= $data->jml_skp ?></td>
                <td><?= $data->Status ?></td>
                <td>
                    <a href="<?= base_url($_SESSION['page']) ?>/detailProposal/<?= $data->Number ?>" class="btn btn-info btn-xs">Detail</a>
                    <a onclick="tambahskpb(this)" data-x="<?= $data->Number; ?>" class="btn btn-primary btn-xs">Add SKP</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#tableProposal').DataTable({
            responsive: true,
            // "scrollX": true
        });

        tambahskpb = (button) => {
            let number = $(button).data('x');
            $('#tambahskpb').load("tambahskpb", {
                number
            }, function() {
                $('#modal-tambahskpb').modal('show');
            });
        };
    });
</script>