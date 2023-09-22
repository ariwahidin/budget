<!DOCTYPE html>
<html>
<head>
  <style>
      #overlay{	
      position: fixed;
      top: 0;
      z-index: 100;
      width: 100%;
      height:100%;
      display: none;
      background: rgba(0,0,0,0.6);
      }

      .cv-spinner {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;  
      }

      .spinner {
      width: 100px;
      height: 100px;
      border: 10px #ddd solid;
      border-top: 10px #2e93e6 solid;
      border-radius: 50%;
      animation: sp-anime 0.8s infinite linear;
      }

      @keyframes sp-anime {
          100% { 
              transform: rotate(360deg); 
          }
      }
      
      .is-hide{
          display:none;
      }
  </style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Budget And Advertising</title>
  <link rel="icon" type="image/x-icon" href="<?=base_url()?>assets/dist/img/pandurasa_kharisma_pt.png">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Datatable -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css">
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
  
  <!-- Select2 -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/select2/dist/css/select2.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Morris charts -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/morris.js/morris.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/skins/_all-skins.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


  <!-- AdminLTE for demo purposes -->
  <!-- <script src="<?=base_url()?>assets/dist/js/demo.js"></script> -->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue-light sidebar-mini <?=$this->uri->segment(1) == 'proposal' ||
                                                              $this->uri->segment(1) == 'absensi' || 
                                                              $this->uri->segment(1) == 'ProposalPromosi_C' || 
                                                              $this->uri->segment(2) == 'tambahActivity' ||
                                                              $this->uri->segment(2) == 'lihatAnggaran' ||
                                                              $this->uri->segment(1) == 'dashboardpo' ? 'sidebar-collapse' : null ?>" style="height: auto; min-height: 100%;">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url('dashboard')?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>K</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Pandurasa</b> Kharisma </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=base_url()?>assets/dist/img/user123.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= $this->fungsi->user_login()->fullname ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=base_url()?>assets/dist/img/user123.png" class="img-circle" alt="User Image">

                <p>
                  <?= $this->fungsi->user_login()->fullname ?>
                </p>
              </li>
              
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=site_url('auth/logout')?>" class="btn btn-danger btn-flat">Log Out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->
  <!-- ChartJS -->
  <script src="<?=base_url()?>assets/bower_components/chart.js/Chart.js"></script>
  <!-- jQuery 3 -->
  <!-- <script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script> -->
  <!-- Datatables -->
  <!-- <script src="<?=base_url()?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
  
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=base_url()?>assets/dist/img/user123.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= $this->fungsi->user_login()->fullname ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <li <?= $this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '' ? 'class="active"' : '' ?>>
          <a href="<?=site_url('dashboard')?>"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
        </li>

        <li class="treeview <?= $this->uri->segment(1) == 'group' || 
                                $this->uri->segment(1) == 'brand' ||
                                $this->uri->segment(1) == 'employee' ||
                                $this->uri->segment(1) == 'product' ||
                                $this->uri->segment(1) == 'promotion' ||
                                $this->uri->segment(1) == 'budget' ||
                                $this->uri->segment(1) == 'customer' ||
                                $this->uri->segment(1) == 'employee' ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-archive"></i>
            <span>Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'group' ? 'class="active"' : '' ?>>
              <a href="<?=site_url('group')?>"><i class="fa fa-tag"></i><span>Group</span></a>
            </li>
            <li <?= $this->uri->segment(1) == 'customer' ? 'class="active"' : '' ?>>
              <a href="<?=site_url('customer')?>"><i class="fa fa-tag"></i><span>Customer</span></a>
            </li>
            <li <?= $this->uri->segment(1) == 'brand' ? 'class="active"' : '' ?>>
              <a href="<?=site_url('brand')?>"><i class="fa fa-tag"></i><span>Brand</span></a>
            </li>
            <li <?= $this->uri->segment(1) == 'product' ? 'class="active"' : '' ?>>
              <a href="<?=site_url('product')?>"><i class="fa fa-tag"></i><span>Item</span></a>
            </li>
            <li <?= $this->uri->segment(1) == 'promotion' ? 'class="active"' : '' ?>>
              <a href="<?=site_url('promotion')?>"><i class="fa fa-tag"></i><span>Promotion</span></a>
            </li>
            <li <?= $this->uri->segment(1) == 'budget' ? 'class="active"' : '' ?>>
              <a href="<?=site_url('budget')?>"><i class="fa fa-tag"></i><span>Budget</span></a>
            </li> 
            <li <?= $this->uri->segment(1) == 'employee' ? 'class="active"' : '' ?>>
              <a href="<?=site_url('employee')?>"><i class="fa fa-user"></i><span>Employee</span></a>
            </li>
          </ul>
        </li>

        <li class="treeview <?=$this->uri->segment(1) == 'proposal' ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-folder-o"></i>
            <span>Proposal Promotion</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'proposalData' ? 'class="active"' : '' ?>><a href="<?=site_url('proposalPromosi_C/proposalData')?>"><i class="fa fa-circle-o"></i> Data Proposal</a></li>
            <!-- <li <?= $this->uri->segment(1) == 'proposal' ? 'class="active"' : '' ?>><a href="<?=site_url('proposal')?>"><i class="fa fa-circle-o"></i> Proposal Form</a></li> -->
          </ul>
        </li>

        <li class="treeview <?=$this->uri->segment(1) == 'anggaran' ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-folder-o"></i>
            <span>Anggaran</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?= $this->uri->segment(1) == 'anggaran' ? 'class="active"' : '' ?>><a href="<?=site_url('anggaran')?>"><i class="fa fa-circle-o"></i> Data Anggaran</a></li>
            <li <?= $this->uri->segment(1) == 'pembelian' ? 'class="active"' : '' ?>><a href="<?=site_url('pembelian')?>"><i class="fa fa-circle-o"></i> Data Pembelian</a></li>
          </ul>
        </li>


        <?php if($this->fungsi->user_login()->level == 1 ){ ?>
        <li class="header">SETTINGS</li>
        <li><a href="<?=site_url('user')?>"><i class="fa fa-user"></i> <span>Users</span></a></li>
        <!-- <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li> -->
        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->
  
  <!-- Select2 -->
  <script src="<?=base_url()?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>

  <!-- date-range-picker -->
  <script src="<?=base_url()?>assets/bower_components/moment/min/moment.min.js"></script>
  <script src="<?=base_url()?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php echo $contents ?>
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2021-2022 <a href="">Pandurasa Kharisma</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?=base_url()?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url()?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/dist/js/adminlte.min.js"></script>

<!-- InputMask -->
<script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="<?=base_url()?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- SlimScroll -->
<script src="<?=base_url()?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?=base_url()?>assets/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url()?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- bootstrap time picker -->
<script src="<?=base_url()?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  });
</script>
<script>
    function CheckNumeric(e) {
        if (window.event) // IE
        {
            if ((e.keyCode <48 || e.keyCode > 57) & e.keyCode != 8 && e.keyCode != 44) {
                event.returnValue = false;
                return false;
            }
        }
        else { // Fire Fox
            if ((e.which <48 || e.which > 57) & e.which != 8 && e.which != 44) {
                e.preventDefault();
                return false;
            }
        }
    }
</script>
<script>
  $(document).ready(function(){
    $('#table_item').DataTable({resposive : true})
  })
  
  $(document).ready(function(){
    $('#table_brand').DataTable({resposive : true})
  })

  $(document).ready(function(){
    $('#table_group').DataTable({resposive : true})
  })

  $(document).ready(function(){
    $('#table_promo').DataTable({resposive : true})
  })

  $(document).ready(function(){
    $('#table_customer').DataTable({resposive : true})
  })

  $(document).ready(function(){
    $('#table_pilih_brand').DataTable({resposive : true})
  })

  $(document).ready(function() {
	    $('#item_barang').DataTable({resposive : true});
  });
</script>

<script>
  $(document).on('click','#idBaru', function(){
        var item_id = $(this).val()
        $(this).text('Select')
        $(this).removeAttr('id')
        $(this).attr('id','button_item_id')
        $(this).removeClass('btn-danger')
        $(this).addClass('btn-primary')
    })
</script>

</body>
</html>
