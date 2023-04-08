<section class="content-header">
    <h1>Form Pengajuan Proposal</h1>
</section>

<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="row">
                <div class="box box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">No Proposal</label>
                        <div class="col-sm-8">
                            <input id="no_proposal" type="text" class="form-control" value="<?=$_POST['no_proposal']?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Periode</label>
                        <div class="col-sm-8">
                            <?php
                                $dates= date_create($_POST['start_date']);
                                $datee= date_create($_POST['end_date']);
                                $newDates = date_format($dates,"d-M-Y"); 
                                $newDatee = date_format($datee, "d-M-Y");
                            ?>
                            <input id="startPeriode" class="form-control" type="text" value="<?=date_format($dates,"Y-m-d")?>">
                            <input id="endPeriode" class="form-control" type="text" value="<?=date_format($datee,"Y-m-d")?>">
                            <input type="text" class="form-control" value="<?=$newDates.' s/d '.$newDatee?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Brand</label>
                        <div class="col-sm-8">
                            <input id="brand_code" type="text" class="form-control" value="<?=$_POST['brand_code']?>">
                            <input type="text" class="form-control" value="<?=getBrandName($_POST['brand_code'])?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Activity</label>
                        <div class="col-sm-8">
                            <input id="code_activity" type="text" class="form-control" value="<?=$_POST['activity_code']?>">
                            <input type="text" class="form-control" value="<?=getActivityName($_POST['activity_code'])?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Pic.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?=$this->fungsi->user_login()->username?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Department</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Budget Type</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Total Costing</label>
                        <div class="col-sm-8">
                            <input id="grand_total_costing" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Total Budget</label>
                        <div class="col-sm-8">
                            <input id="total_budget" type="text" class="form-control" value="<?=$_POST['total_actual_value_budget']?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <?php $this->view('proposalPromosi/formProposalNonSales/content/table_customer.php'); ?>
        </div>
    </div>
</div>
</section>
<?php 
    $this->view('proposalPromosi/formProposalNonSales/content/target_table.php'); 
    $this->view('proposalPromosi/formProposalNonSales/content/target_table_additional.php');
    $this->view('proposalPromosi/formProposalNonSales/content/proses_simpan.php'); 
?>
