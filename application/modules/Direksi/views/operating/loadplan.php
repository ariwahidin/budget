<?php
// var_dump($activity->result());
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Planning
            <a href="<?= base_url($_SESSION['page']) ?>/show_create_form" class="btn btn-primary btn-sm pull-right" style="margin-right: 5px;">Create new proposal</a>
        </h1>
    </section>
    <section class="content">
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
                            <div class="col col-md-3">
                                <label for="">Brand</label><br>
                                <select class="form-control select2" multiple name="" id="filter_brand">
                                    <?php foreach ($brand->result() as $data) { ?>
                                        <option value="<?= $data->BrandCode ?>"><?= $data->BrandName ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col col-md-3">
                                <label for="">Activity</label>
                                <select class="form-control select2" multiple name="" id="filter_activity">
                                    <?php foreach ($activity->result() as $data) { ?>
                                        <option value="<?= $data->id ?>"><?= $data->ActivityName ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col col-md-3">
                                <label for="">Status</label>
                                <select class="form-control select2" multiple name="" id="filter_status">
                                    <option value="open">Open</option>
                                    <option value="approved">Approved</option>
                                    <option value="cancel">Cancel</option>
                                </select>
                            </div>
                            <div class="col col-md-3">
                                <label for="">Action</label>
                                <br>
                                <button onclick="prosesFilter()" class="btn btn-flat btn-default">Filter</button>
                                <button onclick="resetFilter()" class="btn btn-flat  btn-warning">Reset</button>
                                <form style="display: inline;" action="<?= base_url($_SESSION['page'] . '/exportResumeProposalToExcel') ?>" method="POST">
                                    <button type="submit" class="btn btn-flat btn-success">Export to excel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body table-responsive" id="boxTablePrposal">

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
`

<script>
    $(document).ready(function() {
        $('#boxTablePrposal').load("<?= base_url($_SESSION['page']) . '/loadTableProposal' ?>")
    })

    function prosesFilter() {
        var brand = $('#filter_brand').val()
        var activity = $('#filter_activity').val()
        var status = $('#filter_status').val()
        if (brand.length > 0 || activity.length > 0) {
            $('#boxTablePrposal').load("<?= base_url($_SESSION['page']) . '/loadTableProposal' ?>", {
                brand,
                activity,
                status,
            }, function() {

            })
        }
    }

    function resetFilter() {
        $('#boxTablePrposal').load("<?= base_url($_SESSION['page']) . '/loadTableProposal' ?>", {}, function() {
            $('#filter_brand').val(null).trigger('change') // mengosongkan filter
            $('#filter_activity').val(null).trigger('change')
        })
    }

    function cancelProposal(button) {
        const proposal_number = $(button).data('proposal-number')
        Swal.fire({
            title: 'Yakin cancel proposal?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url($_SESSION['page'] . '/cancelProposal') ?>",
                    method: "POST",
                    data: {
                        proposal_number
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success == true) {
                            // Swal.fire('Saved!', '', 'success')
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Cancel proposal berhasil',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = "<?= base_url($_SESSION['page']) ?>/showProposal"
                            })
                        } else {
                            Swal.fire('Gagal cancel proposal', '', 'error')
                        }
                    }
                })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
</script>