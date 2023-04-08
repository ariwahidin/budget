<!-- <?php var_dump($_SESSION) ?> -->
<?php $this->view('header') ?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="content-header">
                <h1>Data Proposal Detail</h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <table>
                                    <tr>
                                        <td>No Proposal</td>
                                        <td>&nbsp;:&nbsp;<b><?= $proposal->row()->Number ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Brand</td>
                                        <td>&nbsp;:&nbsp;<b><?= getBrandName($proposal->row()->BrandCode) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Activity</td>
                                        <td>&nbsp;:&nbsp;<b><?= getActivityName($proposal->row()->Activity) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Start Periode</td>
                                        <td>&nbsp;:&nbsp;<b><?= date('Y-m-d', strtotime($proposal->row()->StartDatePeriode)) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>End Periode</td>
                                        <td>&nbsp;:&nbsp;<b><?= date('Y-m-d', strtotime($proposal->row()->EndDatePeriode)) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>&nbsp;:&nbsp;<b><?= ucfirst($proposal->row()->Status) ?></b></td>
                                    </tr>
                                </table>
                                <?php if ($_SESSION['access_role'] == 'direksi' && $proposal->row()->Status != 'approved' && $proposal->row()->Status != 'cancelled') { ?>
                                    <!-- <a href="<?= base_url($_SESSION['page']) . '/approveProposal/' . $proposal->row()->Number ?>" class="btn btn-primary pull-right" style="margin-left:5px;">Approve</a> -->
                                    <button onclick="approve()" class="btn btn-primary pull-right">Approve</button>
                                    <a href="<?= base_url($_SESSION['page']) . '/cancelProposal/' . $proposal->row()->Number ?>" class="btn btn-danger pull-right" style="margin-right:5px;">Cancel</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3>Items</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-responseive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Item Code</th>
                                            <th>Barcode</th>
                                            <th>Item Name</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Target</th>
                                            <th>Promo(%)</th>
                                            <th>Value</th>
                                            <th>Costing</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyItem">
                                        <?php $no = 1;
                                        foreach ($proposalItem->result() as $item) { ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $item->ItemCode ?></td>
                                                <td><?= $item->Barcode ?></td>
                                                <td><?= $item->ItemName ?></td>
                                                <td><?= number_format($item->Price) ?></td>
                                                <td class="item_qty"><?= $item->Qty ?></td>
                                                <td class="item_target"><?= number_format($item->Target) ?></td>
                                                <td><?= $item->Promo ?></td>
                                                <td class="item_value"><?= number_format(($item->Promo / 100) * $item->Price) ?></td>
                                                <td class="item_costing"><?= number_format($item->Costing) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfooter>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td id="total_qty"></td>
                                            <td id="total_target"></td>
                                            <td></td>
                                            <td id="total_value"></td>
                                            <td id="total_costing"></td>
                                        </tr>
                                    </tfooter>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3>Customer</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-responseive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Group Code</th>
                                            <th>Group Name</th>
                                            <th>Customer Name</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyCustomer">
                                        <?php $num = 1;
                                        foreach ($proposalCustomer->result() as $customer) { ?>
                                            <tr>
                                                <td><?= $num++ ?></td>
                                                <td><?= $customer->GroupCustomer ?></td>
                                                <td><?= $customer->GroupName ?></td>
                                                <td><?= $customer->CustomerName ?></td>
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
    </div>
</div>
<div>
    <?php $this->view('modal_approve.php') ?>
</div>
<?php $this->view('footer') ?>
<script>
    var td_item_qty = document.querySelectorAll('td.item_qty');
    var td_item_target = document.querySelectorAll('td.item_target');
    var td_item_value = document.querySelectorAll('td.item_value');
    var td_item_costing = document.querySelectorAll('td.item_costing');
    var total_qty = 0;
    var total_target = 0;
    var total_value = 0;
    var total_costing = 0;
    for (var i = 0; i < td_item_target.length; i++) {
        total_qty += parseFloat(td_item_qty[i].innerText.replace(/,/g, ''))
        total_target += parseFloat(td_item_target[i].innerText.replace(/,/g, ''))
        total_value += parseFloat(td_item_value[i].innerText.replace(/,/g, ''))
        total_costing += parseFloat(td_item_costing[i].innerText.replace(/,/g, ''))
    }
    document.querySelector('td#total_qty').innerText = total_qty.toLocaleString();
    document.querySelector('td#total_target').innerText = total_target.toLocaleString();
    document.querySelector('td#total_value').innerText = total_value.toLocaleString();
    document.querySelector('td#total_costing').innerText = total_costing.toLocaleString();

    function approve(){
        // alert('aprroved');
        $('#modal_approve').modal('show');
    }
</script>
