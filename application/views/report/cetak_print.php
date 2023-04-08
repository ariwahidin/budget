<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title class="hidden-print">Print Promotion Proposal <?=$detail->invoice?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <!-- <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bootstrap-3.3.7-dist/css/bootstrap.min.css"">
  <link rel="stylesheet" href="<?=base_url()?>assets/bootstrap-4.6.1-dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css"> -->
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css"> -->
  <!-- Theme style -->
    <!-- <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/AdminLTE.min.css"> -->

  <!-- <link rel="stylesheet" type="text/css" href="/style.css"> -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
    @media print {
        @page {
            margin-top: 0;
            margin-bottom: 0;
        }
        body {
            padding-top: 72px;
            padding-bottom: 72px ;
        }
    }
</style>
</head>
<body class="cetak">
<div id="" class="wrapper">


    <!-- Main content -->
    <div class="invoice">

        <div class="row">
            <div class="col-sm-12">
                <p class="pull-right dateProposal">Date Proposal <?=date_format(date_create(substr($detail->created,0,10)),"d-m-Y")?></p>
            </div>
        </div>


        <div class="row kepalaSurat">
            <div class="col-sm-4"></div>
            <div class="col-sm-4 text-center" style="text-align:center;">
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
                    <div class="col-sm-3 invoice-col" style="display: inline;">
                    Pic / Brand 
                    </div>
                    <div class="col-sm-1" style="display: inline;"> 
                        :
                    </div>
                    <div class="col-sm-8" style="display: inline;">
                        <?=ucwords($detail->nama)?> / <?=ucwords($detail->brand_name)?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3" style="display: inline;">
                        Promo Type
                    </div>
                    <div class="col-sm-1" style="display: inline;">
                        :
                    </div>
                    <div class="col-sm-8" style="display: inline;">
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
                <h4 class="box-title">Comment</h4>
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
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="row ">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                Di ajukan oleh:
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr>
                SALES/MKT
            </div>
            <div class="col-md-2">
                Di ketahui oleh:
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr>
                ATASAN
            </div>
            <div class="col-md-2">
                Disetujui Oleh:
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr>
                DEPT HEAD (mkt/sales)
            </div>
            <div class="col-md-2">
                Disetujui Oleh:
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr>
                MANAGEMENT
            </div>
            <div class="col-md-2">
                Updated By:
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr>
                Admin MKT
            </div>
        </div>

    </div>
    
    <div class="clearfix"></div>

</div>
<!-- ./wrapper -->

</body>
<script type="text/javascript">
      window.onload = function() { window.print(); }
 </script>
</html>
