<!DOCTYPE html>
<html>

<head>
    <style>
        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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

        .is-hide {
            display: none;
        }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Budget And Advertising</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/select2/dist/css/select2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url() ?>assets//dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css"> -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- <script type="text/javascript" src="<?= base_url() ?>assets/signature/js/jquery.signature.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?= base_url() ?>assets/signature/js/jquery.ui.touch-punch.min.js"></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/signature/css/jquery.signature.css"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue-light sidebar-mini <?= $this->uri->segment(2) == 'createProposal2' || $this->uri->segment(2) == 'createOperating2' || $this->uri->segment(2) == 'setOperatingActivity' ? 'sidebar-collapse' : '' ?>" style="height: auto; min-height: 100%;">
    <div class="wrapper">
        <header class="main-header">
            <a href="" class="logo">
                <span class="logo-mini"><b>P</b>K</span>
                <span class="logo-lg"><b>Pandurasa</b> Kharisma </span>
            </a>
            <nav class="navbar navbar-static-top">
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
                                <img src="<?= base_url() ?>assets/dist/img/user123.png" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?= $_SESSION['fullname'] ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="<?= base_url() ?>assets/dist/img/user123.png" class="img-circle" alt="User Image">
                                    <p>
                                        <!-- <= $this->fungsi->user_login()->fullname ?> -->
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?= base_url('auth/auth/logout') ?>" class="btn btn-danger btn-flat">Log Out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview <?= $this->uri->segment(2) == 'showGroup' ||
                                            $this->uri->segment(2) == 'showBrand' ||
                                            $this->uri->segment(2) == 'showItem' ||
                                            $this->uri->segment(2) == 'showActivity' ||
                                            $this->uri->segment(2) == 'showCustomer' ||
                                            $this->uri->segment(2) == 'employee' ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-archive"></i>
                            <span>Data Master</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li <?= $this->uri->segment(2) == 'showGroup' ? 'class="active"' : '' ?>>
                                <a href="<?= base_url($_SESSION['page'] . '/showGroup') ?>"><i class="fa fa-tag"></i><span>Group</span></a>
                            </li>
                            <li <?= $this->uri->segment(2) == 'showCustomer' ? 'class="active"' : '' ?>>
                                <a href="<?= base_url($_SESSION['page'] . '/showCustomer') ?>"><i class="fa fa-tag"></i><span>Customer</span></a>
                            </li>
                            <li <?= $this->uri->segment(2) == 'showBrand' ? 'class="active"' : '' ?>>
                                <a href="<?= base_url($_SESSION['page'] . '/showBrand') ?>"><i class="fa fa-tag"></i><span>Brand</span></a>
                            </li>
                            <li <?= $this->uri->segment(2) == 'showItem' ? 'class="active"' : '' ?>>
                                <a href="<?= base_url($_SESSION['page'] . '/showItem') ?>"><i class="fa fa-tag"></i><span>Item</span></a>
                            </li>
                            <li <?= $this->uri->segment(2) == 'showActivity' ? 'class="active"' : '' ?>>
                                <a href="<?= base_url($_SESSION['page'] . '/showActivity') ?>"><i class="fa fa-tag"></i><span>Activity</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview <?= $this->uri->segment(2) == 'createProposal' || $this->uri->segment(2) == 'showProposal' ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-folder-o"></i>
                            <span>Proposal Promotion</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <!-- <li <?= $this->uri->segment(2) == 'createProposal' ? 'class="active"' : '' ?>><a href="<?= base_url($_SESSION['page'] . '/createProposal') ?>"><i class="fa fa-circle-o"></i> Create New Proposal</a></li> -->
                            <li <?= $this->uri->segment(2) == 'showProposal' ? 'class="active"' : '' ?>><a href="<?= base_url($_SESSION['page'] . '/showProposal') ?>"><i class="fa fa-circle-o"></i> Data Proposal</a></li>
                        </ul>
                    </li>
                    <li class="treeview <?= $this->uri->segment(2) == 'createOperating' ||  $this->uri->segment(2) == 'showOperating' || $this->uri->segment(2) == 'showBudgetOperatingPurchase' || $this->uri->segment(2) == 'lihatOperatingActivity' || $this->uri->segment(2) == 'lihatOperatingActivityDetail' ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-folder-o"></i>
                            <span>Budget</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li <?= $this->uri->segment(2) == 'createOperating' ? 'class="active"' : '' ?>><a href="<?= site_url($_SESSION['page'] . '/createOperating') ?>"><i class="fa fa-circle-o"></i> Create New Operating</a></li>
                            <li <?= $this->uri->segment(2) == 'showOperating' || $this->uri->segment(2) == 'lihatOperatingActivity' || $this->uri->segment(2) == 'lihatOperatingActivityDetail' ? 'class="active"' : '' ?>><a href="<?= site_url($_SESSION['page'] . '/showOperating') ?>"><i class="fa fa-circle-o"></i> Budget Activity</a></li>
                            <li <?= $this->uri->segment(2) == 'showBudgetOperatingPurchase' ? 'class="active"' : '' ?>><a href="<?= site_url($_SESSION['page'] . '/showBudgetOperatingPurchase') ?>"><i class="fa fa-circle-o"></i> Data Budget</a></li>
                            <!-- <li <?= $this->uri->segment(2) == 'showPurchase' ? 'class="active"' : '' ?>><a href="<?= site_url($_SESSION['page'] . '/showPurchase') ?>"><i class="fa fa-circle-o"></i> Data Purchase</a></li> -->
                        </ul>
                    </li>
                    <!-- <php if($this->fungsi->user_login()->level == 1 ){ ?> -->
                    <!-- <li class="header">SETTINGS</li> -->
                    <!-- <li><a href="<?= site_url('user') ?>"><i class="fa fa-user"></i> <span>Users</span></a></li> -->
                    <!-- <php } ?> -->
                </ul>
            </section>
        </aside>