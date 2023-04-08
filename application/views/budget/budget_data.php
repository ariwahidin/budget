<section class="content-header">
    <h1>
    Budget
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Budget</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header">
            <div class="pull-right">
                <a href="<?=site_url('budget/add')?>" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i> Create
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table_budget">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Budget</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach($row->result() as $key => $data){ ?>
                    <tr>
                        <td style="width:5%;"><?=$no++ ?>.</td>
                        <td><?= $data->budget_name ?></td>
                        <td class="text-center" width="160px">
                                <a href="<?=site_url('budget/edit/'.$data->id)?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i> Update
                                </a>    
                                <!-- <a href="<?=site_url('budget/del/'.$data->id)?>" onClick="return confirm('Yakin hapus data?')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i> Delete
                                </a> -->
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>

</section>