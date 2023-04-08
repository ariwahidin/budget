<!-- <?php var_dump($operating_purchase->result()) ?> -->
<?php $this->view('header') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Data Budget</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-bordered table-striped table_operating_purchase">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Brand</th>
                                    <th>Periode</th>
                                    <th>Total Operating</th>
                                    <th>YTD Operating</th>
                                    <th>YTD Purchase</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($operating_purchase->result() as $data) { ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$data->BrandName?></td>
                                        <td><?=date('M-Y', strtotime($data->StartPeriode)).' s/d '.date('M-Y', strtotime($data->EndPeriode))?></td>
                                        <td><?=number_format($data->Total_operating)?></td>
                                        <td><?=number_format(get_ytd_operating($data->BudgetCode))?></td>
                                        <td><?=number_format(get_ytd_purchase($data->BrandCode, $data->StartPeriode))?></td>
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
<?php $this->view('footer') ?>
<script>
    $('.table_operating_purchase').dataTable();
</script>