<table class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Value</th>
            <th>Note</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($budget->result() as $data) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= number_format($data->value) ?></td>
                <td><?= $data->note ?></td>
                <td><?= date('d-M-Y', strtotime($data->created_date)) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>