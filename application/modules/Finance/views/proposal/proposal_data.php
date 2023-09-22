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
                                        <select class="form-control select2" multiple name="" id="filter_activity">

                                        </select>
                                    </div>
                                    <div class="col col-md-2">
                                        <label for="">Activity</label><br>
                                        <select class="form-control select2" multiple name="" id="filter_activity">

                                        </select>
                                    </div>

                                    <div class="col col-md-2">
                                        <label for="">Start Periode</label><br>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="col col-md-2">
                                        <label for="">End Periode</label><br>
                                        <input type="date" class="form-control">
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

    function prosesFilter() {
        let brand = $('#filter_brand').val()
        if (brand.length > 0) {
            $('#boxProposal').load("<?= base_url($_SESSION['page']) . '/loadTableProposal' ?>", {brand}, function() {

            })
        }
    }
</script>