<?php


$cek_sumber_dana = $header->row()->TotalPrincipalTargetIDR ?? 0;
$is_supplier_dana = ($cek_sumber_dana > 0) ? 1 : 0;
$is_pk_dana = ($header->row()->TotalPKTargetIDR > 0) ? 1 : 0;

$target_anp = 0;
if ($header->row()->TotalPrincipalTargetIDR == 0) { $target_anp = 0; } 
else { $target_anp = ($header->row()->TotalTargetAnp / $header->row()->TotalPrincipalTargetIDR); }
$target_anp_percent = $target_anp * 100;

$besaranx = ceknum($header->row()->TotalPrincipalTargetIDR);
$besarany = ceknum($header->row()->TotalTargetAnp);
$presentase_0 = ($is_supplier_dana == 1) ? (($besarany / $besaranx)*100)  : 0;


$besarana = ceknum($header->row()->TotalPKTargetIDR) ?? 0;
$besaranb = ceknum($header->row()->TotalPKAnpIDR) ?? 0;
$presentase_1 = ($is_pk_dana == 1) ? (($besaranb / $besarana)*100) : 0;


$operatingx = 0;
$operatingx = ($header->row()->TotalOperating / ($header->row()->TotalTargetAnp + $header->row()->TotalPKAnpIDR));
$operating_percent = $operatingx * 100;


$ceklist0 = ($presentase_0 >= 1) ? "checked='checked'" : "";
$ceklist1 = ($presentase_1 >= 1) ? "checked='checked'" : "";
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
<div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title">Detail Informasi :
                    <?= ucwords(strtolower($brand->BrandName)); ?>
                </strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
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
                        <td><input type="checkbox" disabled="disabled" <?= $ceklist0 ?>>
                            Supplier</td>
                        <td>Presentase Pembelian</td>
                        <td>&nbsp;:&nbsp;
                            <?= number_format($presentase_0) ?> %
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="checkbox" disabled="disabled" <?= $ceklist1 ?>> Pandurasa </td>
                        <td>Presentase Penjualan</td>
                        <td>&nbsp;:&nbsp;
                            <?= number_format($presentase_1) ?>%
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
                        <td>Fiscal Year</td>
                        <td>&nbsp;:&nbsp;
                            <?= date('M-Y', strtotime($operating->result()[0]->Periode)) ?> - 
                            
                            <?= date('M-Y', strtotime($operating->result()[11]->Periode)) ?>
                        <!-- </td>
                        <td>Fiscal Year</td>
                        <td>&nbsp;:&nbsp;
                            <?= date('M-Y', strtotime($operating->result()[11]->Periode)) ?>
                        </td> -->
                        
                        <td>Used Amount </td>
                        <td>&nbsp;:&nbsp;
                            <?= number_format($hmaster->row()->TotalCosting);  ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Operating (
                            <?= round($operating_percent); ?>%)
                        </td>
                        <td>&nbsp;:&nbsp;
                            <?= number_format($header->row()->TotalOperating);  ?>
                        </td>
                        
                        <td>Claim Amount to PK</td>
                        <td>&nbsp;:&nbsp;
                            <?= number_format($hmaster->row()->TotalIncomingAmount); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>DN Amount (
                            <?= round($operating_percent); ?>%)
                        </td>
                        <td>&nbsp;:&nbsp;
                            <?= number_format($hmaster->row()->Totaldn); ?>
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
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Filter By Activity</h4>
                        <table  class="table table-bordered  table-striped table-hover dataTable" role="grid" id="tabel_act">
                            <thead>
                                <tr onclick="encok('<?= $hmaster->row()->BrandCode ?>-')">
                                    <th>ID</th>
                                    <th>Aktivitas</th>
                                    <th>Operational Budget</th>
                                    <th>Used Amount</th>
                                    <th>% Used</th>
                                </tr>
                            </thead>
                            <?php 
                                foreach ($filteract->result() as $filterx) { 
                                    $persen = (($filterx->Used / $filterx->BudgetActivity) * 100);
                                    $persen = ($filterx->Used >= $filterx->BudgetActivity) ? (($persen > 0) ? $persen : 0) : 0; 
                            ?>
                            <tr onclick="encok('<?= $filterx->BrandCode." -".$filterx->ActivityCode; ?>')">
                                <td><?= ($filterx->ID); ?></td>
                                <td><?= ucwords(strtolower($filterx->ActivityName)); ?></td>
                                <td><?= number_format($filterx->BudgetActivity); ?></td>
                                <td><?= number_format($filterx->Used); ?></td>
                                <td><?= number_format($persen,0,".",",") ?? 0; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
<!--                     
                    <div class="col-lg-6">
                        <h4>Filter By Region</h4>
                        <table class="table table-responsive" id="tabel_kota">
                            <thead>
                                <tr onclick="encok('<?= $hmaster->row()->BrandCode ?>-')">
                                    <th>Kota</th>
                                    <th>Costing</th>
                                    <th>% Operating</th>
                                    <th>% Costing</th>
                                </tr>
                            </thead>
                            <?php foreach ($filterkota->result() as $filterx) { ?>
                            <tr onclick="encok('<?= $filterx->BrandCode." -".$filterx->ActivityCode; ?>')">
                                <td>
                                    <?= ucwords(strtolower($filterx->City)); ?>
                                </td>
                                <td>
                                    <?= number_format($filterx->totalang); ?>
                                </td>
                                <td>
                                    <?= number_format((($filterx->totalang / $header->row()->TotalOperating) * 100), 2, ',', '.'); ?>
                                </td>
                                <td>
                                    <?= number_format((($filterx->totalang / $hmaster->row()->TotalCosting) * 100), 2, ',', '.'); ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>

                    </div> -->

                </div>
                <!-- <hr>
                <div id="propd">
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
                                <td>
                                    <?= $no++ ?>
                                </td>
                                <td>
                                    <?= $data->Number ?>
                                </td>
                                <td>
                                    <?= getActivityName($data->Activity) ?>
                                </td>
                                <td style="text-align: right;">
                                    <?= number_format($data->TotalCosting) ?>
                                </td>
                                <td>
                                    <?= ucfirst($data->CreatedBy) ?>
                                </td>
                                <td>
                                    <?= date('d M Y', strtotime($data->CreatedDate)) ?>
                                </td>
                                <td>
                                    <span class="">
                                        <?= ucfirst($data->Status) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php foreach (getApprovedBy($data->Number)->result() as $a) { ?>
                                    <?php if ($a->is_approve == 'y') { ?>
                                    <span class="label label-success"><i class="fa fa-check"></i>
                                        <?= ucfirst($a->fullname) . " " . date('d/m/y', strtotime($a->created_at)) ?>
                                    </span><br>
                                    <?php } else { ?>
                                    <span class="label label-danger"><i class="fa fa-close"></i>
                                        <?= ucfirst($a->fullname) . " " . date('d/m/y', strtotime($a->created_at)) ?>
                                    </span><br>
                                    <?php } ?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>


                </div> -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    let encok = (par) => {
        let expar = par.split("-"), code = expar[0], acx = expar[1];
        $.ajax({
            type: 'POST',
            url: "<?= base_url($_SESSION['page']) . '/propd' ?>",
            data: 'code=' + code + '&actx=' + acx,
            success: function (response) {

                $('#propd').html();
                $('#propd').html(response);
                angkakanan();
            }
        });
    };
$(document).ready(function() {
    
    angkakanan();

    
    $('#tabel_act').DataTable({ resposive: true });
    $('#tabel_kota').DataTable({ resposive: true });
    $('#table_proposal').DataTable({ resposive: true });
});
</script>