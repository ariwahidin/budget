<?php

if($var_brand){


    $nullkah = $operating->row()->nullkah ?? 0;

    $cek_sumber_dana = $header->row()->TotalPrincipalTargetIDR ?? 0;
    $is_supplier_dana = ($cek_sumber_dana > 1) ? 1 : 0;

    
    $ceklist0 = ($is_supplier_dana == 1) ? "checked='checked'" : "";
    $ceklist1 = ($is_supplier_dana == 0) ? "checked='checked'" : "";
    
    $target_anp = 0;
    if ($header->row()->TotalPrincipalTargetIDR == 0) { $target_anp = 0; } 
    else { $target_anp = ($header->row()->TotalTargetAnp / $header->row()->TotalPrincipalTargetIDR); }
    $target_anp_percent = $target_anp * 100;
    
    $besaranx = ceknum($header->row()->TotalPrincipalTargetIDR);
    $besarany = ceknum($header->row()->TotalTargetAnp);
    $presentase_0 = ($is_supplier_dana == 1) ? (($besarany / $besaranx)*100)  : 0;
    
    
    $besarana = ceknum($header->row()->TotalPKTargetIDR) ?? 0;
    $besaranb = ceknum($header->row()->TotalPKAnpIDR) ?? 0;
    $presentase_1 = ($is_supplier_dana == 0) ? (($besaranb / $besarana)*100) : 0;
    
    
    $operatingx = 0;
    $operatingx = ($header->row()->TotalOperating / ($header->row()->TotalTargetAnp + $header->row()->TotalPKAnpIDR));
    $operating_percent = $operatingx * 100;

    $startp = ($nullkah == 0) ? date('M-Y', strtotime($operating->result()[0]->Periode)) : $operating->row()->startp;
    $endp = ($nullkah == 0) ? date('M-Y', strtotime($operating->result()[2]->Periode)) : $operating->row()->endp;
}
?>
<style>
.modal-title {
    font-weight: bold;
    font-size: 2.4rem;
}

table.custom {
    width: 100%;
    margin: 0 0 30px;
    border-radius: 8px;
    background: #e3e0e0;
    overflow: hidden;
    padding: 10px;
    color: #000;
    font-weight: bold;
}

.custom table {
    width: 100%;
}

.custom td {
    padding: 5px 10px;
    border-bottom: 2px solid #fff;
}

td:nth-child(even) {
    background: #fff;
    color: #000;
}

.modal-dialog {
    width: 90%;
    margin: 20px auto;
}

h4 {
    font-size: 1.8rem;
    font-weight: bold;
}
</style>
<?php if($var_brand){ ?>
<table class="custom">
    <tr>
        <td>Brand</td>
        <td>&nbsp;:&nbsp;
            <?= getBrandName($operating->row()->BrandCode) ?>
        </td>
        <td>Mata Uang</td>
        <td>&nbsp;:&nbsp;
            <?= strtoupper($operating->result()[0]->Valas); ?>
        </td>
    </tr>
    <tr>
        <td>Sumber Dana</td>
        <td><input type="checkbox" disabled="disabled" <?= $ceklist0 ?>> Supplier</td>
        <td>Presentase</td>
        <td>&nbsp;:&nbsp;
            <?= number_format($presentase_0,2,",",".") ?> %
        </td>
    </tr>
    <tr>
        <td></td>
        <td><input type="checkbox" disabled="disabled" <?= $ceklist1 ?>> Pandurasa </td>
        <td>Presentase</td>
        <td>&nbsp;:&nbsp;
            <?= number_format($presentase_1,2,",",".") ?>%
        </td>
    </tr>
    <tr>
        <td>Start Periode</td>
        <td>&nbsp;:&nbsp;
            <?= $startp ?>
        </td>
        <td>End Periode </td>
        <td>&nbsp;:&nbsp;
            <?= $endp ?>
        </td>
    </tr>
    <?php if($is_supplier_dana == 1){ ?>
    <tr>
        <td>Principal Target</td>
        <td>&nbsp;:&nbsp;
            <?= number_format($header->row()->TotalPrincipalTargetIDR) ?>
        </td>
        <td>Principal A&P</td>
        <td>&nbsp;:&nbsp;
            <?= number_format($header->row()->TotalTargetAnp) ?>
        </td>
    </tr>
    <?php } ?>

    <?php if($is_supplier_dana == 0){ ?>
    <tr>
        <td>PK Target</td>
        <td>&nbsp;:&nbsp;
            <?= number_format($header->row()->TotalPKTargetIDR) ?>
        </td>
        <td>PK A&P</td>
        <td>&nbsp;:&nbsp;
            <?= number_format($header->row()->TotalPKAnpIDR) ?>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td>Operating (
            <?= round($operating_percent); ?>%)
        </td>
        <td>&nbsp;:&nbsp;
            <?= number_format($header->row()->TotalOperating);  ?>
        </td>
        <td>Costing </td>
        <td>&nbsp;:&nbsp;
            <?= number_format($hmaster->row()->TotalCosting);  ?>
        </td>
    </tr>
    <tr>
        <td>DN Amount (
            <?= round($operating_percent); ?>%)
        </td>
        <td>&nbsp;:&nbsp;
            <?= number_format($hmaster->row()->Totaldn); ?>
        </td>
        <td>Claim Amount </td>
        <td>&nbsp;:&nbsp;
            <?= number_format($hmaster->row()->TotalIncomingAmount); ?>
        </td>
    </tr>
    <tr style="display:none">
        <?php $total_actual_anp = 0; $total_actual_anp = $actual_purchase * $target_anp; ?>
        <td>Actual A&P (
            <?= round($target_anp_percent) ?>%)
        </td>
        <td>&nbsp;:&nbsp;
            <?= number_format($total_actual_anp) ?>
        </td>
    </tr>
</table>
<hr>
<?php } ?>