<div class="modal fade" id="modal-set-budget" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Set Budget</h4>
            </div>
            <div class="modal-body">
                <?php 
                    // var_dump($pembelian);
                ?>
                <table width="250px">
                    <tr>
                        <td>Periode</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=$pembelian['tahun']?></td>
                    </tr>
                    <tr>
                        <td>Brand</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?=getBrandName($pembelian['code_brand'])?></td>
                    </tr>
                    <tr>
                        <td>Presentase (%)</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td>
                            <input id="presentase" type="tel" size="4" maxlength="3" onkeypress="CheckNumeric(event);" />
                        </td>
                    </tr>
                </table>

                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Bulan.</td>
                            <td>Purchase</td>
                            <td>Presentase</td>
                            <td>Budget</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; for($i = 0; $i < count($pembelian['bulan']); $i++) {?>
                        <tr>
                            <td><?=$no++?></td>
                            <td>
                                <?=getMonth($pembelian['bulan'][$i])?>
                            </td>
                            <td class="td_nominal"><?=$pembelian['nominal'][$i]?></td>
                            <td class="td_presentase"></td>
                            <td class="td_budget"></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button id="simpan_budget" class="btn btn-primary">
                    <i class="fa fa-plane"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#modal-set-budget').modal('show');
    });
</script>
<script>
    $(document).ready(function(){
        $("#presentase").keyup(function(){
            var presentase = $(this).val();
            $('.td_presentase').text(presentase);

            var nominal = document.getElementsByClassName("td_nominal");
            var budget = document.getElementsByClassName("td_budget");
            // console.log(nominal.length);
            for(var i = 0; i < nominal.length; i++){
                angka = nominal[i].innerText;
                angka = angka.replace(/,/g, '');
                // console.log(angka);
                var b = parseFloat(angka) * (parseFloat(presentase)/100);
                b = Math.floor(b)
                b = numberWithCommas(b);
                budget[i].innerHTML = b ;
            }

        });

        $('#simpan_budget').on('click', function(){
            var tahun = '<?=$pembelian['tahun']?>';
            var brand_code = '<?=$pembelian['code_brand']?>';
            var presentase = $('#presentase').val();
            var month = JSON.parse('<?=json_encode($pembelian['bulan'])?>');
            var purchase = JSON.parse('<?=json_encode($pembelian['nominal'])?>');
            var budgetClass = document.getElementsByClassName("td_budget");
            var budget = [];
            for(var i = 0; i < budgetClass.length; i++){
                budget.push(budgetClass[i].innerText);
            }

            if(presentase == ''){
                alert('Presentase kosong');
            }else if(presentase > 100){
                alert('presentase lebih dari 100%');
            }else{
                $.ajax({
                    url : '<?=site_url('pembelian/simpanBudget')?>',
                    type : 'POST',
                    data : {
                        tahun : tahun,
                        brand_code : brand_code,
                        presentase : presentase,
                        month : month,
                        purchase : purchase,
                        budget : budget,
                    },
                    dataType: 'JSON',
                    success: function(response){
                        if(response.success == true){
                            alert('Data berhasil disimpan');
                            window.location = '<?=site_url('anggaran')?>';
                        }
                    }
                });
            }

        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $('.select2').select2();
    })
</script>