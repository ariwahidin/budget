<tr>
    <div class="form-group">
        <td style="vertical-align:top;">
            <label>Type Promo</label>
        </td>
        <td>
            <select class="form-control select2" id="multipleSelectPromo"
                    style="width: 100%;">
                    <option value="">--Pilih--</option>
                <?php foreach($promo as $p => $data) { ?>
                    <option value="<?=$data->sid?>">
                        <?=$data->name?>
                    </option>
                <?php } ?>
            </select>
        </td>   
    </div>
</tr>
<script type="text/javascript">
    $('#multipleSelectPromo').select2()
</script>