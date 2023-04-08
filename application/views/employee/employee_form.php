<section class="content-header">
    <h1>
    Employee
    <small>Data Employee</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Employee</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box_title"><?=ucfirst($page)?> Employee</h3>
            <div class="pull-right">
                <a href="<?=site_url('employee')?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="<?=site_url('employee/process')?>" method="post">
                        <div class="form-group">
                            <label for="">Employe Code</label>
                            <input name="employee_code" type="text" class="form-control" readonly value="<?=$row->nik?>">
                        </div>
                        <div class="form-group">
                            <label for="employee_name">Employee Name *</label>
                            <input name="user_id" type="hidden" value="<?= $this->fungsi->user_login()->id ?>">
                            <input name="employee_id" type="hidden" value="<?=$row->id?>">
                            <input type="text" name="employee_name" value="<?=$row->namakaryawan?>" class="form-control" style="text-transform:uppercase" required>
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