 <script type="text/javascript" src="<?= base_url() ?>assets/signature/js/jquery.signature.min.js"></script>
 <script type="text/javascript" src="<?= base_url() ?>assets/signature/js/jquery.ui.touch-punch.min.js"></script>
 <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/signature/css/jquery.signature.css">
 <style>
     .kbw-signature {
         max-width: 400px;
         max-height: 400px;
     }

     #sig canvas {
         width: 100% !important;
         height: auto;
     }
 </style>
 <div class="row">
     <div class="col-md-12">
         <div class="modal fade" id="modal_approve" role="dialog">
             <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                         <h4 class="modal-title">Approve Proposal</h4>
                     </div>
                     <div class="modal-body">
                         <form method="POST" action="<?=base_url($_SESSION['page'].'/approveProposal')?>">
                            <input type="hidden" name="number_proposal" value="<?=$proposal->row()->Number?>">
                             <label class="" for="">Tanda Tangan:</label>
                             <br />
                             <div id="sig"></div>
                             <br />
                             <textarea id="signature64" name="signed" style="display: none"></textarea>
                             <br />
                     </div>
                     <div class="modal-footer">
                         <button class="btn btn-success pull-right">Submit</button>
                         <button id="clear" class="btn btn-warning pull-right" style="margin-right:5px;">Clear</button>
                     </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <script type="text/javascript">
     var sig = $('#sig').signature({
         syncField: '#signature64',
         syncFormat: 'PNG'
     });
     $('#clear').click(function(e) {
         e.preventDefault();
         sig.signature('clear');
         $("#signature64").val('');
     });
 </script>