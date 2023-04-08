<?php
// include("koneksi.php")
?>
<style>
    #overlay{	
    position: fixed;
    top: 0;
    z-index: 100;
    width: 100%;
    height:100%;
    display: none;
    background: rgba(0,0,0,0.6);
    }

    .cv-spinner {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;  
    }

    .spinner {
    width: 100px;
    height: 100px;
    border: 10px #ddd solid;
    border-top: 10px #2e93e6 solid;
    border-radius: 50%;
    animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
        100% { 
            transform: rotate(360deg); 
        }
    }
    
    .is-hide{
        display:none;
    }
</style>
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-md-12">
                    <button id="insert" class="btn btn-primary pull-right">
                        import to sql server    
                    </button>
                </div>
            </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th>badgenumber</th>
                            <th>timeclock</th>
                            <th>isproses</th>
                            <th>verifymode</th>
                            <th>inoutmode</th>
                            <th>workcode</th>
                        </tr>
                        <?php while ($value = odbc_fetch_array($data)) {?>
                            <tr>
                                <td class="badgenumber"><?php echo $value["badgenumber"]; ?></td>
                                <td class="timeclock"><?php echo $value["timeclock"]; ?></td>
                                <td class="isproses"><?php echo $value["isproses"]; ?></td>
                                <td class="verifymode"><?php echo $value["verifymode"]; ?></td>
                                <td class="inoutmode"><?php echo $value["inoutmode"]; ?></td>
                                <td class="workcode"><?php echo $value["workcode"]; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>

<script>
    $(document).ready(function(){

        $('#insert').on('click', function(){
            if (confirm("Yakin import data ini") == true) {
                // text = "You pressed OK!";
                tambah();
            } else {
                text = "You canceled!";
            }
        })


        function tambah(){
            var badgenumber = $('.badgenumber');
            var timeclock = $('.timeclock');
            var isproses = $('.isproses');
            var verifymode = $('.verifymode');
            var inoutmode = $('.inoutmode');
            var workcode = $('.workcode');
            var badgenumber_s = [];
            var timeclock_s = [];
            var isproses_s = [];
            var verifymode_s = [];
            var inoutmode_s = [];
            var workcode_s = [];
            var $data = [];

            for(var i = 0; i < badgenumber.length; i++ ){
                badgenumber_s.push(badgenumber[i].innerText);
                timeclock_s.push(timeclock[i].innerText);
                isproses_s.push(isproses[i].innerText);
                verifymode_s.push(verifymode[i].innerText);
                inoutmode_s.push(inoutmode[i].innerText);
                workcode_s.push(workcode[i].innerText);
            }

            $(document).ajaxSend(function(){
                $("#overlay").fadeIn(300);　
            });
            
            $.ajax({
                url : '<?=site_url('absensi/insertAbsent')?>',
                type : 'POST',
                data : {
                    badgenumber : badgenumber_s,
                    timeclock : timeclock_s,
                    isproses : isproses_s,
                    verifymode : verifymode_s,
                    inoutmode : inoutmode_s,
                    workcode : workcode_s
                },
                dataType : 'JSON',
                success : function(response){
                    if(response.success == true){
                        alert('data berhasil diimport');
                    }else{
                        alert('data gagal diimport');
                    }
                },
            }).done(function(){
                setTimeout(function(){
                    $("#overlay").fadeOut(300);
                },500);
            });	
        }
    })
</script>