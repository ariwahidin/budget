<?php 
    // var_dump($brand->result());
?>
<section class="content-header">
    <h1>
    Users
    </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="<?=site_url('user/insert_user')?>" method="post">
                        <div class="form-group">
                            <label for="fullname">Name *</label>
                            <input type="text" name="fullname" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username *</label>
                            <input type="text" name="username" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" name="password" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="level">Level *</label>
                            <select name="level" class="form-control select2" required>
                                <option value="">- Pilih -</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-flat">
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

<script>
    $(document).ready(function(){
        $('.select2').select2();
    })
</script>