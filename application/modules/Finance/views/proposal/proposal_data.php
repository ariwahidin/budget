<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header">
                <strong>Data Proposal</strong>
            </div>
            <div class="box-body table-responsive" id="boxProposal">

            </div>
        </div>
    </section>
</div>
<div id="tambahskpb"></div>
<script>
    $(document).ready(function() {
        $('#boxProposal').load("<?= base_url($_SESSION['page']) . 'loadTableProposal' ?>", {}, function() {

        })
    })
</script>