<div class="content-wrapper">
    <section class="content-header">
        <strong>Detail Proposal</strong>
        <button onclick="loadModalInputSKP(this)" data-number="<?= $number ?>" class="btn btn-primary btn-sm pull-right">SKP</button>
    </section>
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Number Proposal</th>
                                    <th>Brand</th>
                                    <th>Activity</th>
                                    <th>Start Periode</th>
                                    <th>End Periode</th>
                                    <th>Total Costing</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $proposal->Number ?></td>
                                    <td><?= $proposal->BrandName ?></td>
                                    <td><?= $proposal->ActivityName ?></td>
                                    <td><?= date('d M Y', strtotime($proposal->StartDatePeriode)) ?></td>
                                    <td><?= date('d M Y', strtotime($proposal->EndDatePeriode)) ?></td>
                                    <td><?= number_format($total_costing) ?></td>
                                    <td><?= $proposal->Status ?></td>
                                    <td><?= $proposal->CreatedBy ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Mechanism</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Mechanism</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($mechanism->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->Mechanism ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Objective</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Objective</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($objective->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->Objective ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Comment</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($comment->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->Comment ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail Item</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Proposal Number</th>
                                    <th>Barcode</th>
                                    <th>ItemName</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Target</th>
                                    <th>Promo Value</th>
                                    <th>Costing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                $totalCosting = 0;
                                foreach ($item->result() as $data) {
                                    $totalCosting += $data->Costing; ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->ProposalNumber ?></td>
                                        <td><?= $data->FrgnName ?></td>
                                        <td><?= $data->ItemName ?></td>
                                        <td><?= number_format($data->Price) ?></td>
                                        <td><?= number_format($data->Qty) ?></td>
                                        <td><?= number_format($data->Target) ?></td>
                                        <td><?= number_format($data->PromoValue) ?></td>
                                        <td><?= number_format($data->Costing) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8"><strong>Total</strong></td>
                                    <td><strong><?= number_format($totalCosting) ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lain - lain</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Description</th>
                                    <th>Costing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                $totalCosting = 0;
                                foreach ($other->result() as $data) {
                                    $totalCosting += $data->Costing ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->Desc ?></td>
                                        <td><?= number_format($data->Costing) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><strong>Total</strong></td>
                                    <td><strong><?= number_format($totalCosting) ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Group Customer</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Group Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($group->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->GroupName ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customer</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered" id="tableCustomer">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($customer->result() as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->CustomerName ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="modalInputSKP"></div>
<script>
    function loadModalInputSKP(button) {
        let number = $(button).data('number')
        $('#modalInputSKP').load("<?= base_url($_SESSION['page']) ?>/loadModalInputSKP", {
            number
        }, function() {
            $('#modal-input-skp').modal('show')
        })
    }

    $('#tableCustomer').DataTable({resposive : true})
</script>