<section class="content-header">
    <h1>
    Customers
    <small>Pelanggan</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Customers</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box_title"><?=ucfirst($page)?> Customer</h3>
            <div class="pull-right">
                <a href="<?=site_url('customer')?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <form action="<?=site_url('customer/process')?>" method="post">
                                <div class="form-group">
                                    <label for="">Group Store</label>
                                    <select name="group_code" class="form-control select2" id="" required>
                                        <option value="">- Pilih -</option>
                                        <?php  foreach($group as $g){?>
                                            <option <?=$g->GroupCode == $code ? 'selected' : ''?> value="<?=$g->GroupCode?>"><?=$g->GroupName?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="customer_name">Customer Name *</label>
                                    <input name="user_id" type="hidden" value="<?=$this->fungsi->user_login()->id?>">
                                    <input name="customer_id" type="hidden" value="<?=$row->CustomerId?>">
                                    <input type="text" name="customer_name" value="<?=$row->CustomerName?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="<?=$page?>" class="btn btn-success btn-flat">
                                        <i class="fa fa-paper-plane"></i> Save
                                    </button>
                                    <button type="Reset" class="btn btn-flat">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        
    </div>
</section>