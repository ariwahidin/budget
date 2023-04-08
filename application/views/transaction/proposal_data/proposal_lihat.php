<section class="content-header">
    <h1>
     Detail Proposal
    <small><?=$transaksi->no_doc?></small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="#">Proposal Promotion</a></li>
    <li class="active">Data Proposal</li>
    </ol>
</section>
    <!-- Main content -->
    <section class="invoice">
        <div class="row">
            <div class="col-sm-12">
                <p class="pull-right">Date Proposal <?=date_format(date_create(substr($transaksi->transaction_date,0,10)),"d-m-Y")?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4 text-center">
                <h3>Proposal Promotion</h3>
                <?=$transaksi->no_doc?>
                <p>Periode: <?=indo_date($transaksi->start_date)?> s/d <?=indo_date($transaksi->end_date)?></p>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <br>
        <br>
        <br>
        <div class="row invoice-info">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-4 invoice-col">
                    Pic / Deparment
                    </div>
                    <div class="col-sm-1">
                        :
                    </div>
                    <div class="col-sm-7">
                        <?=ucwords($transaksi->pic)?> / <?=ucwords($transaksi->department_name)?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 invoice-col">
                    Brand 
                    </div>
                    <div class="col-sm-1">
                        :
                    </div>
                    <div class="col-sm-7">
                        <?=ucwords($transaksi->brand_name)?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        Promo Type
                    </div>
                    <div class="col-sm-1">
                        :
                    </div>
                    <div class="col-sm-7">
                        <?=ucwords($transaksi->promo_name)?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        Budget Type
                    </div>
                    <div class="col-sm-1">
                        :
                    </div>
                    <div class="col-sm-7">
                        <?=$transaksi->budget_name?><br> 
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-2">
                    Outlet
                    </div>
                    <div class="col-sm-1">
                        :
                    </div>
                    <div class="col-sm-9">
                        <?php foreach($customer->result() as $customer){ ?>
                            <?=ucwords($customer->customer_name)?><br> 
                        <?php } ?>
                    </div>
                </div> 
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-3">
                        Objective                
                    </div>
                    <div class="col-sm-1">
                        :
                    </div>
                    <div class="col-sm-8">
                        <?php $no = 1; foreach($objective->result() as $o){?>
                            <?=$no++.'. '.ucwords($o->objective)?><br>
                        <?php } ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        Mechanism
                    </div>
                    <div class="col-sm-1">
                        :
                    </div>
                    <div class="col-sm-8">
                        <?php $no = 1; foreach($mechanism->result() as $m){?>
                            <?=$no++.'. '.ucwords($m->mechanism)?><br>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>



      <!-- Table row -->
      
    <div class="row">
        <div class="col-sm-12">
            <br>
            <h4 class="page-header">Sales Target
            </h4>
        </div>
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                <th style="width:5%">No.</th>
                <th>Product</th>
                <th>Barcode</th>
                <th>Price</th>
                <th class="text-center"><?=ucwords($transaksi->sales_type)?></th>
                <th class="text-center">Total Estimation</th>
                <th>Value</th>
                </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    <?php foreach($detail as $dtl){ ?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=ucwords($dtl->item_name)?></td>
                            <td><?=$dtl->barcode?></td>
                            <td><?=number_format($dtl->item_price)?></td>
                            <td class="text-center"><?=$dtl->sales?></td>
                            <td class="text-center"><?=$dtl->target?></td>
                            <td><?=number_format($dtl->target_value)?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td><b>Total</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b><?=number_format($totalTarget->total_target)?></b></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <br>
            <h4 class="page-header">Costing
            </h4>
        </div>
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:5%">No.</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Value</th>
                        <th class="text-center">Promo</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    <?php foreach($detail as $costing){ ?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=ucwords($costing->item_name)?></td>
                            <td><?=number_format($costing->item_price)?></td>
                            <td><?=ceil($costing->target)?></td>
                            <td><?=number_format($costing->promo_value)?></td>
                            <td class="text-center"><?=$costing->promo?>%</td>
                            <td><?=number_format($costing->costing_value)?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td><b>Total</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b><?=number_format($totalCosting->total_costing)?></b></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <hr>
        <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Comment</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <p><?=ucwords($transaksi->comment)?></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="<?=site_url('proposalData/cetakProposalDetail/').$transaksi->no_doc?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
