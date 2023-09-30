<table class="table table-responsive table-bordered table-striped" id="table_proposal">
                    <thead>
                        <tr>
                                    <th>No.</th>
                                    <th>No Proposal</th>
                                    <th>Activity</th>
                                    <th>Costing</th>
                                    <th>Pic</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Management</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($proposal->result() as $data) { ?>
                                    <tr>
                                    <td><?= $no++ ?></td>
                                        <td><?= $data->Number ?></td>
                                        <td><?= getActivityName($data->Activity) ?></td>
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
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
<script>
    
    $('#table_proposal').DataTable({resposive : true});
</script>

                