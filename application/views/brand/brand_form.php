<section class="content-header">
    <h1>
    Brand
    <small>Data Brand</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Brand</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box_title"><?=ucfirst($page)?> Brand</h3>
            <div class="pull-right">
                <a href="<?=site_url('brand')?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="<?=site_url('brand/process')?>" method="post">
                        <div class="form-group">
                            <label for="">Brand Code</label>
                            <input name="brand_code" type="text" class="form-control" readonly value="<?=$brand_code?>">
                        </div>
                        <div class="form-group">
                            <label for="brand_name">Brand Name *</label>
                            <input name="user_id" type="hidden" value="<?= $this->fungsi->user_login()->id ?>">
                            <input name="brand_id" type="hidden" value="<?=$row->id?>">
                            <input type="text" name="brand_name" value="<?=$row->BrandName?>" class="form-control" style="text-transform:uppercase" required>
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