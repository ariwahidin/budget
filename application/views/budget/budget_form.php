<section class="content-header">
    <h1>
    budget
    <small>Data budget</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">budget</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box_title"><?=ucfirst($page)?> budget</h3>
            <div class="pull-right">
                <a href="<?=site_url('budget')?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="<?=site_url('budget/process')?>" method="post">
                        <div class="form-group">
                            <label for="budget_name">Budget Name *</label>
                            <input name="user_id" type="hidden" value="<?= $this->fungsi->user_login()->id ?>">
                            <input name="budget_id" type="hidden" value="<?=$row->id?>">
                            <input type="text" name="budget_name" value="<?=$row->budget_name?>" class="form-control" style="text-transform:uppercase" required>
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