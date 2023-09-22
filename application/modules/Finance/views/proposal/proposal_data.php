<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Filter <i class="fa fa-filter"></i></h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col col-md-2">
                                        <label for="">Brand</label><br>
                                        <select class="form-control select2" multiple name="" id="filter_brand">
                                            <?php foreach ($brand->result() as $data) { ?>
                                                <option value="<?= $data->BrandCode ?>"><?= $data->BrandName ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col col-md-2">
                                        <label for="">Group Customer</label><br>
                                        <select class="form-control select2" multiple name="" id="filter_group">
                                            <?php foreach ($group->result() as $data) { ?>
                                                <option value="<?= $data->GroupCustomer ?>"><?= $data->GroupName ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col col-md-2">
                                        <label for="">Activity</label><br>
                                        <select class="form-control select2" multiple name="" id="filter_activity">
                                            <?php foreach ($activity->result() as $data) { ?>
                                                <option value="<?= $data->id ?>"><?= $data->ActivityName ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col col-md-2">
                                        <label for="">Start Periode</label><br>
                                        <input type="date" class="form-control" id="start_date">
                                    </div>
                                    <div class="col col-md-2">
                                        <label for="">End Periode</label><br>
                                        <input type="date" class="form-control" id="end_date">
                                    </div>
                                    <div class="col col-md-2">
                                        <label for="">Action</label>
                                        <br>
                                        <button onclick="prosesFilter()" class="btn btn-flat btn-default">Filter</button>
                                        <button onclick="resetFilter()" class="btn btn-flat  btn-warning">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Proposal <i class="fa fa-document"></i></h3>
                    </div>
                    <div class="box-body table-responsive" id="boxProposal">

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="tambahskpb"></div>
<script>
    $(document).ready(function() {
        $('#boxProposal').load("<?= base_url($_SESSION['page']) . '/loadTableProposal' ?>", {}, function() {

        })
    })

    // let prosesPerkalian = (a = null,b = null)=>{
    //     a = a??3;
    //     b = b??5;
    //     let c = a * b;
    //     console.log(c);
    //     return a * b;
    // };
    // prosesPerkalian(5,5);

    function prosesFilter() {
        let brand = $('#filter_brand').val()
        let group = $('#filter_group').val()
        let activity = $('#filter_activity').val()
        let start_date = $('#start_date').val()
        let end_date = $('#end_date').val()
        // console.log(brand)
        // console.log(group)
        // console.log(activity)
        // console.log(start_date)
        // console.log(end_date)
        if (brand.length > 0 || group.length > 0 || activity.length > 0 || start_date != '' || end_date != '') {
            $('#boxProposal').load("<?= base_url($_SESSION['page']) . '/loadTableProposal' ?>", {
                brand,
                group,
                activity,
                start_date,
                end_date,
            }, function() {

            })
        }
    }

    function resetFilter() {
        $('#boxProposal').load("<?= base_url($_SESSION['page']) . '/loadTableProposal' ?>", {}, function() {
            $('#filter_brand').val(null).trigger('change') // mengosongkan filter
            $('#filter_group').val(null).trigger('change')
            $('#filter_activity').val(null).trigger('change')
            $('#start_date').val(null).trigger('change')
            $('#end_date').val(null).trigger('change')
        })
    }
</script>