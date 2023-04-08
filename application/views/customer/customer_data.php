<section class="content-header">
    <h1>
    Customers
    <small>Pelanggan</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Customers</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box_title">Data Customers</h3>
            <div class="pull-right">
                <a href="<?=site_url('customer/add')?>" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i> Create
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table_customer">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Group Name</th>
                        <th>Customer Name</th>
                        <!-- <th>Address</th>
                        <th>Phone</th>
                        <th>Term</th>-->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        
    </div>

</section>

<script>
$(document).ready(function(){
    $('#table_customer').DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":{
            "url" : "<?=site_url('customer/get_ajax')?>",
            "type" : "POST",       
        },
        "columnDefs" :[
            {
                "targets": [0,3],
                "orderable":false
            },
        ],
        "order": [],
    })
})

</script>