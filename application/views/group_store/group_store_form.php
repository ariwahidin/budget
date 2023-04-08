<section class="content-header">
    <h1>
    Group Store
    <small>Data Group Store</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Group Store</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box_title"><?=ucfirst($page)?> Group Store</h3>
            <div class="pull-right">
                <a href="<?=site_url('group_store')?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="<?=site_url('group/process')?>" method="post">
                        <div class="form-group">
                            <label for="">Group Code</label>
                            <input name="group_code" type="text" class="form-control" value="<?=$GroupCode?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="group_store_name">Group Name *</label>
                            <input name="user_id" type="hidden" value="<?= $this->fungsi->user_login()->id ?>">
                            <input name="group_id" type="hidden" value="<?=$row->id?>">
                            <input type="text" name="group_name" value="<?=$row->GroupName?>" class="form-control" style="text-transform:uppercase" required >
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
</section>