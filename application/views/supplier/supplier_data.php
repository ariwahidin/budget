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
            <h3 class="box_title">Data Suppliers</h3>
            <div class="pull-right">
                <a href="<?=site_url('supplier/add')?>" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i> Create
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>No telepon</th>
                        <th>NPWP</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach($row->result() as $key => $data){ ?>
                    <tr>
                        <td style="width:5%;"><?=$no++ ?>.</td>
                        <td><?= $data->supplier_code ?></td>
                        <td><?= $data->supplier_name ?></td>
                        <td><?= $data->address_1 ?></td>
                        <td><?= $data->email ?></td>
                        <td><?= $data->telephone?></td>
                        <td><?= $data->npwp?></td>
                        <td class="text-center" width="160px">
                                <a href="<?=site_url('supplier/edit/'.$data->sid)?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i> Update
                                </a>    
                                <!-- <a href="<?=site_url('supplier/del/'.$data->sid)?>" onClick="return confirm('Yakin hapus data?')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i> Delete
                                </a> -->
                                <a href="#modalDelete" data-toggle="modal" onClick="$('#modalDelete #formDelete').attr('action','<?=site_url('supplier/del/'.$data->sid)?>')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i> Delete
                                </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>

</section>
<div class="modal fade" id="modalDelete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Yakin akan menghapus data ini?</h4>
            </div>
            <div class="modal-footer">
                <form id="formDelete" action="" method="post">
                    <button class="btn btn-danger" data-dismiss>Tidak</button>
                    <button type="submit" class="btn btn-default">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>