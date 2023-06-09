<section class="content-header">
    <h1>
    Dashboard
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard active"></i> Dashboard</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Items</span>
            <span class="info-box-number"><?=$this->fungsi->count_item()?></span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Customers</span>
            <span class="info-box-number"><?=$this->fungsi->count_customer()?></span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-user-plus"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Users</span>
            <span class="info-box-number"><?=$this->fungsi->count_user()?></span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-sticky-note-o"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Proposal</span>
            <span class="info-box-number"><?=$this->fungsi->count_proposal()?></span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    </div>

</section>