<table class="table table-bordered table-striped" id="tableUserDireksi">
    <thead>
        <tr>
            <th>#</th>
            <th>User Code</th>
            <th>Fullname</th>
            <th>Username</th>
            <th>Page</th>
            <th>Level</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($direksi->result() as $data) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data->user_code ?></td>
                <td><?= $data->fullname ?></td>
                <td><?= $data->username ?></td>
                <td><?= $data->page ?></td>
                <td><?= $data->level ?></td>
                <td>
                    <button onclick="loadModalEditLevel(this)" data-id="<?= $data->id ?>" class="btn btn-primary btn-xs">Edit Level</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#tableUserDireksi').DataTable()
    })
</script>