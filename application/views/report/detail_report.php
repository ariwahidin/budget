<section class="content-header">
    <h1>
     Detail Proposal
    <small><?=$detail->invoice?></small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li>
    <li class="active">Invoice</li>
    </ol>
</section>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <!-- <div class="row">
        <div class="col-xs-12">
            <p class="pull-right">Periode:  </p>
            <br>
            <hr>
        </div>
        <!-- /.col -->
      <!-- </div> -->
      <!-- info row -->

        <div class="row">
            <div class="col-sm-12">
                <p class="pull-right">Date Proposal <?=date_format(date_create(substr($detail->created,0,10)),"d-m-Y")?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4 text-center">
                <h3>Proposal Promotion</h3>
                <?=$detail->invoice?>
                <p>Periode: <?=indo_date($detail->periode_start)?> s/d <?=indo_date($detail->periode_end)?></p>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <br>
        <br>
        <br>
        <div class="row invoice-info">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-3 invoice-col">
                    Pic / Brand 
                    </div>
                    <div class="col-sm-1">
                        :
                    </div>
                    <div class="col-sm-8">
                        <?=ucwords($detail->nama)?> / <?=ucwords($detail->brand_name)?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        Promo Type
                    </div>
                    <div class="col-sm-1">
                        :
                    </div>
                    <div class="col-sm-8">
                        <?php foreach($promo as $p){ ?>
                            <?=$p->promo_name?><br> 
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        Budget Type
                    </div>
                    <div class="col-sm-1">
                        :
                    </div>
                    <div class="col-sm-8">
                        <?=$detail->claim_name?><br> 
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
                        <?php foreach($outlet as $o){ ?>
                            <?=ucwords($o->outlet_name)?><br> 
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
                        <?php $no = 1; foreach($objective as $o){?>
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
                        <?php $no = 1; foreach($mechanism as $m){?>
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
                <th>No.</th>
                <th>Product</th>
                <th>Barcode</th>
                <th>Price</th>
                <th>Last Year</th>
                <th>Last 3 Month</th>
                <th>Total Estimation</th>
                <th>Value</th>
                </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    <?php foreach($target as $tgt){ ?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=ucwords($tgt->product_name)?></td>
                            <td><?=$tgt->product_barcode?></td>
                            <td><?=number_format($tgt->product_price)?></td>
                            <td><?=$tgt->last_year?></td>
                            <td><?=$tgt->last_3_month?></td>
                            <td><?=ceil($tgt->estimation)?></td>
                            <td><?=number_format($tgt->value_target_item)?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td><b>Total</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b><?=number_format($detail->total_target)?></b></td>
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
                        <th>No.</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Value</th>
                        <th>Promo</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    <?php foreach($target as $cost){ ?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=ucwords($cost->product_name)?></td>
                            <td><?=number_format($cost->product_price)?></td>
                            <td><?=ceil($cost->estimation)?></td>
                            <td><?=number_format($cost->value_discount)?></td>
                            <td><?=$cost->discount?>%</td>
                            <td><?=number_format($cost->value_costing_item)?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td><b>Total</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b><?=number_format($detail->total_costing)?></b></td>
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
              <p><?=ucwords($comment->comment)?></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="<?=site_url('report/cetak/').$detail->sale_id?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
