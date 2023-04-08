<?php 
// var_dump($sales_avg);
// var_dump($from_sales);
?>

<section class="content-header">
    <h1>
    Form Pengajuan Promotion Proposal
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li>Transaction</li>
    <li class="active">Proposal Form</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-4">
            <?php $this->view('transaction/proposal/proposal_row_1_col_1') ?>
        </div>
        <div class="col-lg-4">
            <?php $this->view('transaction/proposal/proposal_row_1_col_2') ?>
        </div>
        <div class="col-lg-4">
            <?php $this->view('transaction/proposal/proposal_row_1_col_3') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php $this->view('transaction/proposal/proposal_promosi/target_table') ?>
        </div>
    </div>
    <div class="row">
        <?php $this->view('transaction/proposal/proposal_row_3') ?>
    </div>
</section>



<?php $this->view('transaction/proposal/proposal_footer') ?>
<?php $this->view('transaction/proposal/proses_simpan') ?>