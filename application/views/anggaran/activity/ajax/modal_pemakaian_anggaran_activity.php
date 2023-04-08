<div class="modal fade" id="modal-pemakaian-anggaran-activity" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pemakaian Anggaran Proposal ZAI019201290</h4>
            </div>
            <div class="modal-body">
                    <?php 
                        var_dump($detail->result());
                    ?>
                     <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td><strong>No Proposal</strong></td>
                                <td> : ZAI90709890980</td>
                            </tr>
                            <tr>
                                <td><strong>No Anggaran</strong></td>
                                <td>: 89088908</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Pemakaian</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Desember</td>
                                <td>5,000,000</td>
                            </tr>
                            <tr>
                                <td>November</td>
                                <td>5,000,000</td>
                            </tr>
                        </tbody>
                     </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#modal-pemakaian-anggaran-activity').modal('show');
    });
</script>