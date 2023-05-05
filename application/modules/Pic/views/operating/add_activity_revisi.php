<div class="row row_activity">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <b><?= getActivityName($activity) ?>&nbsp;:&nbsp;</b>
                <table>
                    <tr>
                        <td>
                            <input type="hidden" class="act" value="<?= $activity ?>">
                        </td>
                        <td>
                            <input oninput="hitungValuePerActivity(this)" type="number" class="form-control inputPrecentagePeractivity" style="max-width:60px">
                        </td>
                        <td>
                            &nbsp;<b>%</b>&nbsp;
                        </td>
                        <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Value&nbsp;:&nbsp;</b>
                        </td>
                        <td>
                            <input type="text" class="form-control inputValuePerActivity" readonly>
                        </td>
                        <td>
                            <button onclick="deleteForm(this)" class="btn btn-danger pull-right" style="margin-left: 10px;">Delete</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>