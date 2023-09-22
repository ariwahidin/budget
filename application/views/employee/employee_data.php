<style>
    .text-center:{
        text-align : center !important;
    }
</style>
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
            <h3 class="box_title">Data Employee</h3>
            <div class="pull-right">
                <!-- <a href="<?=site_url('employee/add')?>" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i> Create
                </a> -->
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table_employee">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th class="text-center">Employee Code</th>
                        <!-- <th>Nama Employee</th> -->
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach($row->result() as $key => $data){ ?>
                    <tr>
                        <td style="width:5%;"><?=$no++ ?>.</td>
                        <!-- <td style="width:15%" class="text-center"><?= $data->nik?></td> -->
                        <td><?= $data->namakaryawan?></td>
                        <td class="text-center" width="160px">
                                <a href="<?=site_url('employee/edit/'.$data->id)?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i> Update
                                </a>    
                                <!-- <a href="<?=site_url('employee/del/'.$data->id)?>" onClick="return confirm('Yakin hapus data?')" class="btn btn-danger btn-xs">
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
<script>
    $('#table_employee').DataTable({resposive : true});
</script>