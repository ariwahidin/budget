<?php 
    // var_dump($proposalHeader->result());
    // var_dump($proposalTargetItem->result());
    // var_dump($customer->result());
?>
<section class="content-header">
    <h1>
    Detail Proposal
    </h1>
</section>

<section  class="content">
    <div class="box">
        <div class="box-header">
            <div class="col-md-6">
                <table>
                    <tr>
                        <td>No. Proposal</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=$proposalHeader->row()->no_proposal?></td>
                    </tr>
                    <tr>
                        <td>Brand</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=getBrandName($proposalHeader->row()->brand_code)?></td>
                    </tr>
                    <tr>
                        <td>Pic</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=getUsername($proposalHeader->row()->created_by)?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=date('d-m-Y', strtotime($proposalHeader->row()->start_periode)).' s/d '.date('d-m-Y', strtotime($proposalHeader->row()->end_periode))?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=$proposalHeader->row()->is_approve == 'y' ? 'Approved' : 'On Process' ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Description</th>
                        <th>Barcode</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Target value</th>
                        <th>Promo Value</th>
                        <th>Promo</th>
                        <th>Costing Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($proposalTargetItem->result() as $data){?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=$data->ItemName?></td>
                            <td><?=$data->Barcode?></td>
                            <td><?=$data->price?></td>
                            <td><?=$data->quantity_target?></td>
                            <td><?=$data->target_value?></td>
                            <td><?=$data->promo_value?></td>
                            <td><?=$data->promo?></td>
                            <td><?=$data->costing_value?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><b>Total</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b><?=$proposalHeader->row()->total_target?></b></td>
                        <td></td>
                        <td></td>
                        <td><b><?=$proposalHeader->row()->total_costing?></b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Customer Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($customer->result() as $c){ ?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=$c->CustomerName?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>        
</section>
