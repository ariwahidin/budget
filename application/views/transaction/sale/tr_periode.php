<tr>
    <td style="vertical-align:top">
        <label>Periode </label>
    </td>
    <td>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="periode">
            </div>
        </div>
    </td>                      
</tr>
<script type="text/javascript">
    $('#periode').daterangepicker({
        locale: {
                format: 'DD-MM-YYYY',
                }
    })
</script>