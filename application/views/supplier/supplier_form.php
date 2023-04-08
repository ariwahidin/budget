<section class="content-header">
    <h1>
    Suppliers
    <small>Pemasok Barang</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Suppliers</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box_title"><?=ucfirst($page)?> Supplier</h3>
            <div class="pull-right">
                <a href="<?=site_url('supplier')?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"></i> Back
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="<?=site_url('supplier/process')?>" method="post">
                        <div class="form-group">
                            <label for="supplier_code">Supplier Code *</label>
                            <input type="hidden" name="username" value="<?=$this->fungsi->user_login()->username?>">
                            <input type="hidden" name="user_id" value="<?=$this->fungsi->user_login()->id?>">
                            <input type="hidden" name="id" value="<?=$row->sid?>">
                            <input type="text" name="supplier_code" value="<?=$row->supplier_code?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="supplier_name">Supplier Name *</label>
                            <input type="text" name="supplier_name" value="<?=$row->supplier_name?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address_1">Address 1 *</label>
                            <textarea type="text" name="address_1" class="form-control" required><?=$row->address_1?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Address 2 </label>
                            <textarea type="text" name="address_2" class="form-control"><?=$row->address_2?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone_1">Phone 1 *</label>
                            <input type="number" name="phone_1" value="<?=$row->telephone?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="npwp">NPWP</label>
                            <input type="number" name="npwp" value="<?=$row->npwp?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="<?=$row->email?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Term</label>
                            <input type="number" name="term" value="<?=$row->term?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="brand_status">Status *</label>
                            <select name="supplier_status" class="form-control" id="" required>
                                <option value="">- Pilih -</option>
                                <option value="y" <?=$row->is_active == 'y' ? 'selected' :'' ?>>Aktif</option>
                                <option value="n" <?=$row->is_active == 'n' ? 'selected' :'' ?>>Tidak Aktif</option>
                            </select>
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