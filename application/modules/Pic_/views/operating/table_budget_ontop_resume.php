<div class="box box-primary">
    <div class="box-header">
        <b>On Top Summary</b>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped" style="font-size: 11px;">
            <thead>
                <tr>
                    <th>Budget</th>
                    <th>Used</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= number_format($totalOnTop) ?></td>
                    <td><?= number_format($totalCostingOnTop) ?></td>
                    <td><?= number_format($balanceOnTop) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>