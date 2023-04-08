<tr>
    <td style="vertical-align:center;">
        <label for="">Brand *</label>
    </td>
    <td>
        <div class="form-group">
            <div class="input-group">
                <input id="brand_id" type="hidden">
                <input type="text" id="brand_name" class="form-control" readonly>
                <span class="input-group-btn">
                    <button type="button" class="btn btn-info btn-flat form-control" data-toggle="modal" data-target="#modal-pilih-brand">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td class="vertical input-group" style="vertical-align:center">
        <label for="">Budget Type</label>
    </td>
    <td>
        <select id="claim" class="form-control select2" style="width: 100%">
            <option value="">-- Pilih --</option>
            <?php foreach($claim->result() as $claim => $c){?>
                <option value="<?=$c->id?>"><?=$c->claim_to?></option>
            <?php } ?>
        </select>
    </td>
</tr>
