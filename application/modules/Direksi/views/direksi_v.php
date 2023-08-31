<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <!-- <small>advanced tables</small> -->
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>
                            <strong>
                                <?= number_format($resumeAnp->row()->TotalOperating) ?>
                            </strong>
                        </h4>
                        <p>Operating 2023</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-square-o"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>
                            <strong>
                                <?= number_format($resumeAnp->row()->TotalProposalCosting) ?>
                            </strong>
                        </h4>
                        <p>Proposal Cost 2023</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-square-o"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>
                            <strong>
                                <?= number_format($resumeAnp->row()->TotalOperatingBalance) ?>
                            </strong>
                        </h4>
                        <p>Operating Balance 2023</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-square-o"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h4>
                            <strong>
                                <?= getTotalProposal() ?>
                            </strong>
                        </h4>
                        <p>Total Proposal</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-copy"></i>
                    </div>
                    <a onclick="loadingShow()" href="<?= base_url($_SESSION['page'] . '/showProposal') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= getProposalApproved() ?></h3>

                        <p>Proposal Approved</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-square-o"></i>
                    </div>
                    <a href="<?= base_url($_SESSION['page'] . '/showProposalApproved/approved') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div> -->
            <!-- ./col -->
            <!-- <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= getProposalOpen() ?></h3>

                        <p>Proposal Open</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <a href="<?= base_url($_SESSION['page'] . '/showProposalApproved/open') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div> -->
            <!-- ./col -->

            <!-- ./col -->

            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="box box-primary">
                    <div class="box-header">
                        <form action="<?= base_url($_SESSION['page'] . '/downloadExcel') ?>" method="POST" id="formCetakExcel"></form>
                        <h3 class="box-title">Report Budget A&P</h3>
                        <button id="btnDownloadExcel" class="btn btn-success btn-sm pull-right">Download Excel</button>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="table1" class="table table-bordered  table-striped table-hover dataTable" role="grid" aria-describedby="example2_info">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Brand</th>
                                                <th>Start Periode</th>
                                                <th>End Periode</th>
                                                <th>Operating</th>
                                                <th>Costing</th>
                                                <th style="background-color: #FFDBAA;">Claim Amount</th>
                                                <th style="background-color: #FFB7B7;">Used Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($anp->result() as $data) { ?>
                                                <tr role="row" class="odd">
                                                    <th><?= $no++ ?></th>
                                                    <td><?= $data->BrandName ?></td>
                                                    <td><?= $data->StartPeriode ?></td>
                                                    <td><?= $data->EndPeriode ?></td>
                                                    <td style="text-align: right;"><?= number_format($data->TotalOperatingBudget) ?></td>
                                                    <td style="text-align: right;"><?= number_format($data->TotalCosting) ?></td>
                                                    <td style="text-align: right;background-color: #FFDBAA;"> <?= number_format($data->IncomingAmount) ?></td>
                                                    <td style="background-color: #FFB7B7;"></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->view('footer') ?>
<script>
    $('#btnDownloadExcel').on('click', function() {
        $('#formCetakExcel').submit()
    })
</script>