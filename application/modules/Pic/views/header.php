<!DOCTYPE html>
<html>

<head>
    <!-- <style>
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
    </style> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Budget And Advertising</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/dist/img/pandurasa_kharisma_pt.png">
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
    <link type="text/css" href="<?= base_url() ?>assets/css/checkbox_dataTables.css" rel="stylesheet" />
    <link type="text/css" href="<?= base_url() ?>assets/css/jquery_dataTables.css" rel="stylesheet" />
    <link type="text/css" href="<?= base_url() ?>assets/css/select_dataTables.css" rel="stylesheet" />
    <link type="text/css" href="<?= base_url() ?>assets/css/sweetalert2.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>assets//dist/css/skins/_all-skins.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<style>
    body {
        font-family: "Helvetica Neue", Helvetica, Arial, Helvetica, sans-serif;
        font-size: 1.124em;
        font-weight: normal;
    }

    .select2-selection__choice {
        background-color: blueviolet !important;
    }

    section.content {
        min-height: auto !important;
    }
</style>

<style>
    /* Absolute Center Spinner */
    .loading {
        content: 'tunggu';
        position: fixed;
        z-index: 9999;
        height: 2em;
        width: 2em;
        overflow: show;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    /* Transparent Overlay */
    .loading:before {
        content: 'tunggu';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
        background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
        /* hide "loading..." text */
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }

    .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 150ms infinite linear;
        -moz-animation: spinner 150ms infinite linear;
        -ms-animation: spinner 150ms infinite linear;
        -o-animation: spinner 150ms infinite linear;
        animation: spinner 150ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>
<div id="muncul_loading" class=""></div>

<body class="hold-transition skin-black-light <?= $this->uri->segment(2) == 'setOperatingActivity' ? '' : 'sidebar-mini' ?> <?= $this->uri->segment(2) == 'ShowDetailBudget' || $this->uri->segment(2) == 'setOperatingActivity' ||
                                                                                                                            $this->uri->segment(2) == 'createOperating2' ||
                                                                                                                            $this->uri->segment(2) == 'show_form_proposal_from_sales' ||
                                                                                                                            $this->uri->segment(2) == 'showFormAddOnTop' ||
                                                                                                                            $this->uri->segment(2) == 'show_form_create_budget' ? 'sidebar-collapse' : '' ?>" style="height: auto; min-height: 100%;">
    <div class="wrapper">
        <header class="main-header">

            <a href="" class="logo">
                <span class="logo-mini">
                    <img src="<?= base_url() ?>assets/dist/img/pandurasa_kharisma_pt.png" style="max-width:30px;border-radius:5%; padding-bottom:-10px;" alt="">
                </span>
                <span class="logo-lg">
                    <img src="<?= base_url() ?>assets/dist/img/pandurasa_kharisma_pt.png" style="max-width:25px;border-radius:10%; padding-bottom:-10px;" alt="">
                    <span style="font-size: 14px;">
                        <b>Pandurasa</b> Kharisma
                    </span>
                </span>
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
                                <img src="<?= base_url() ?>assets/dist/img/red-user.png" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?= ucfirst($_SESSION['fullname']) ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="<?= base_url() ?>assets/dist/img/red-user.png" class="img-circle" alt="User Image">
                                    <p>
                                        <span class=""><?= ucfirst($_SESSION['fullname']) ?></span>
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
                    <li class="treeview <?= $this->uri->segment(2) == 'show_create_form' || $this->uri->segment(2) == 'showProposal' ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-folder-o"></i>
                            <span>Proposal Promotion</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li <?= $this->uri->segment(2) == 'show_create_form' ? 'class="active"' : '' ?>><a href="<?= base_url($_SESSION['page']) . '/show_create_form' ?>"><i class="fa fa-circle-o"></i> Create New Proposal</a></li>
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
                            <li <?= $this->uri->segment(2) == 'createOperating' ? 'class="active"' : '' ?>><a href="<?= site_url($_SESSION['page'] . '/createOperating') ?>"><i class="fa fa-circle-o"></i> Create New Budget</a></li>
                            <li <?= $this->uri->segment(2) == 'showOperating' || $this->uri->segment(2) == 'lihatOperatingActivity' || $this->uri->segment(2) == 'lihatOperatingActivityDetail' ? 'class="active"' : '' ?>><a href="<?= site_url($_SESSION['page'] . '/showOperating') ?>"><i class="fa fa-circle-o"></i> Budget </a></li>
                            <!-- <li <?= $this->uri->segment(2) == 'showBudgetOperatingPurchase' ? 'class="active"' : '' ?>><a href="<?= site_url($_SESSION['page'] . '/showBudgetOperatingPurchase') ?>"><i class="fa fa-circle-o"></i> Data Budget</a></li> -->
                            <!-- <li <?= $this->uri->segment(2) == 'showPurchase' ? 'class="active"' : '' ?>><a href="<?= site_url($_SESSION['page'] . '/showPurchase') ?>"><i class="fa fa-circle-o"></i> Data Purchase</a></li> -->
                        </ul>
                    </li>
                </ul>
            </section>
        </aside>