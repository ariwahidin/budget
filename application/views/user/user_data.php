<section class="content-header">
    <h1>
    Users
    <small>Pengguna</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Users</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box_title">Data Users</h3>
            <div class="pull-right">
                <a href="<?=site_url('user/add')?>" class="btn btn-primary btn-flat">
                    <i class="fa fa-user-plus"></i> Create
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table_user">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Name</th>
                        <!-- <th>Brand</th> -->
                        <!-- <th>Address</th> -->
                        <!-- <th>Password</th> -->
                        <th>Status</th>
                        <th>Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach($row->result() as $key => $data){ ?>
                    <tr>
                        <td><?=$no++ ?>.</td>
                        <td><?= $data->username ?></td>
                        <td><?= $data->fullname ?></td>
                        <!-- <td><?= $data->password?></td> -->
                        <!-- <td><?= getBrandNameForUser($data->user_brand) ?></td> -->
                        <!-- <td><?= $data->alamat ?></td> -->
                        <td>
                            <a href="" class="btn btn-primary btn-xs">active</a>
                        </td>
                        <td><?= $data->level == 1 ? "Admin" : "User" ?></td>
                        <td class="text-center" width="160px">
                            <form action="<?=site_url('user/del')?>" method="post">    
                                <a href="<?=site_url('user/edit/'.$data->id)?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i> Update
                                </a>
                                <input type="hidden" name="user_id" value="<?=$data->id?>">
                                <button onClick="return confirm('Apakah anda yakin?')" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>

</section>
<script>
    $(document).ready(function(){
        $('#table_user').DataTable();
    })
</script>