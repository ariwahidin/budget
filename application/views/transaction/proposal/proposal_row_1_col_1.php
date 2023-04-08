<div class="box box-widget">
    <div class="box-body">
        <table width="100%">
            <tr>
                <td style="vertical-align:center; width:20%">
                    <label for="">No. </label>
                </td>
                <td>
                    <div class="form-group">
                        <h4><b id="no_proposal"><span id="brand_aka"></span><span id="invoice"><?=$no_transaction?></span></b></h4>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align:center">
                    <label for="">Pic.</label>
                </td>
                <td>
                    <div class="form-group">
                        <select id="employee" class="form-control select2" style="width: 100%">
                            <option value="">-- Pilih --</option>
                            <?php foreach($employee->result() as $data){?>
                                <option value="<?=$data->nik?>"><?=$data->namakaryawan?></option>
                            <?php } ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align:center;">
                    <label for="">Department</label>
                </td>
                <td>
                    <div class="form-group">
                        <select id="department" class="form-control select2" style="width: 100%">
                            <option value="">-- Pilih --</option>
                            <?php foreach($department->result() as $data){?>
                                <option value="<?=$data->id?>"><?=$data->department_name?></option>
                            <?php } ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align:center;">
                    <label for="">Brand</label>
                </td>
                <td>
                    <div class="form-group">
                        <div class="input-group">
                            <input id="brand_code" type="hidden" class="form-control" value="<?=$code_brand?>" >
                            <input type="text" id="brand_name" class="form-control" value="<?=getBrandName($code_brand)?>" readonly>
                        </div>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td>
                    <label>Periode </label>
                </td>
                <td>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control pull-right" id="periode" readonly value="<?=$start_date.' s/d '.$end_date?>">
                        </div>
                    </div>
                </td>                      
            </tr>
            <tr>
                <td>
                    <label for="">Activity </label>
                </td>
                <td>
                    <div class="form-group">
                        <input id="multipleSelectPromo" type="hidden" class="form-control" value="<?=$activity?>">
                        <input type="text" class="form-control" value="<?=getActivityName($activity)?>" readonly>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Budget Type</label>
                </td>
                <td>
                    <div class="form-group">
                    <select id="claim" class="form-control select2" style="width: 100%">
                        <option value="">-- Pilih --</option>
                        <?php foreach($budget as $data){?>
                            <option value="<?=$data->id?>"><?=$data->budget_name?></option>
                        <?php } ?>
                    </select>
                    </div>
                </td>
            </tr>

        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click','#chose_brand',function(){
    $('#brand_code').val($(this).data('brand_code'))
    $('#brand_name').val($(this).data('brand_name'))
    })
</script>
<script type="text/javascript">
    $('#employee').select2()   
    $('#department').select2()
</script>
<script>
    $(document).ready(function(){
        var brand_name = document.getElementById("brand_name").value;
        brand_name = brand_name.replace(/ /g,'');
        brand = brand_name.substring(0, 3);
        var t = document.getElementById("brand_aka");
        t.innerHTML = brand;    
    });
</script>