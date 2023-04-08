<div class="row">
    <div class="col-lg-3">
        <div class="box box-widget">
            <div class="box-body">
                <div class="form-group divObj">
                    <label>Objective</label>
                    <input type="text" class="form-control obj" placeholder="Masukan Objective">
                 </div>
                 <button id="add_obj" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
                 <button id="hapusColumnObj" type="button" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="box box-widget">
            <div class="box-body">
                <div class="form-group bgst">
                    <label>Promotion Mechanism</label>
                    <input type="text" class="form-control mec" placeholder="Masukan Promotion Mechanism">
                 </div>
                 <button id="add_column" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus" ></i></button>
                 <button id="hapusColumn"  type="button" class="btn btn-danger btn-sm" ><i class="fa fa-minus"></i></button>
            </div>
        </div>
    </div>
    <script>

        $(document).on('click','#add_column',function(){
            $('.bgst').append($('<div>',{
                                        class: 'form-group'
                                        })
                        ).append($('<input>',{
                                        class: 'form-control mec'
                                        }))
        })

        $(document).on('click','#hapusColumn',function(){
            var elem = $('.mec')
            for(var i = 0; i < elem.length; i++){
                var urut = [i] + 1
            }
            if (urut != '01'){
                elem[i-1].remove()
            }           
        })

    </script>

    <script>

        $(document).on('click','#add_obj',function(){
            $('.divObj').append($('<div>',{
                                        class: 'form-group'
                                        })
                        ).append($('<input>',{
                                        class: 'form-control obj'
                                        }))
        })

        $(document).on('click','#hapusColumnObj',function(){
            var elem = $('.obj')
            for(var i = 0; i < elem.length; i++){
                var urut = [i] + 1
            }
            if (urut != '01'){
                elem[i-1].remove()
            }           
        })

    </script>
    <div class="col-lg-3">
        <div class="box box-widget">
            <div class="box-body">
                <div class="form-group">
                    <label for="note">Comment</label>
                    <textarea id="comment" rows="3" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div>
            <button id="cancel_payment" class="btn btn-warning">
                <i class="fa fa-refresh"></i> Cancel
            </button><br><br>
            <button id="process_payment" class="btn btn-flat btn-lg btn-success">
                <i class="fa fa-paper-plane-o"></i> Process
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
  

    // process payment
    $(document).on('click','#process_payment',function(){

        var periode = $('#periode').val()
        var startDate = periode.substring(0, 10)
        var endDate = periode.substring(13, 23)
        var outlet = $('#cust').val()
        var typePromo = $('#multipleSelectPromo').val()
        var totalTarget = $('#totalSalesTarget').text()
        var totalCosting = $('#totalCosting').text()
        var rowOutletCount = $('#outletName').length       
        var rowProductCount = $('#productName').length
        var idBrand = $('#brand_id').val()
        var claim = $('#claim').val()
        var mechanismItem = $('.mec')
        var allMechanism =[]
        for(var i = 0; i < mechanismItem.length; i++){  
            var data = $(mechanismItem[i]).val()              
            allMechanism.push(data)
        }
        // console.log(allMechanism)


        var objItem = $('.obj')
        var allObj =[]
        for(var x = 0; x < objItem.length; x++){
            var isi = $(objItem[x]).val()
            allObj.push(isi)
        }
        // console.log(allObj)

        var mechanism = allMechanism
        var objective = allObj

        var comment = $('#comment').val();

        if(idBrand == '') 
            {
                alert('Brand tidak boleh Kosong')
                $('#brand_id').focus()
            }
        else if(startDate == endDate){
            alert('Tanggal periode sama')
            $('#periode').focus()
        }
        else if(typePromo == '') 
            {
                alert('Promo belum dipilih')
                $('#multipleSelectPromo').focus()
            }
        else if(rowOutletCount == 0 ) 
        {
            alert('Outlet belum dupilih')
            $('#cust').focus()
        }
        else if(rowProductCount == 0 ) 
        {
            alert('Item belum dupilih')
            $('#brand_name').focus()
        }
        else if(mechanismItem.val() == '' ) 
        {
            alert('Mechanism belum disi')
            mechanismItem.focus()
        }
        else if(objItem.val() == '' ) 
        {
            alert('Objective belum disi')
            objItem.focus()
        }
        else if(claim == '' ) 
        {
            alert('Budget type belum disi')
            $('#claim').focus()
        }      
        else {
            if(confirm('Yakin proses transaksi ini?')){
                $.ajax({
                    type : 'POST',
                    url : '<?=site_url('sale/process')?>',
                    data : {
                            'process_payment': true,
                            'startDate': startDate,
                            'endDate': endDate,
                            'outlet': outlet,
                            'typePromo': typePromo,
                            'totalTarget': totalTarget,
                            'totalCosting': totalCosting,
                            'idBrand' : idBrand,
                            'claim' : claim,
                            'mechanism' : mechanism,
                            'objective' : objective,
                            'comment' : comment,
                            },
                    dataType: 'json',
                    success: function(result){

                        // alert('Masokk')
                        if(result.success){
                            alert('Transaksi berhasil');
                            window.open('<?=site_url('report/sale')?>')
                        }else{
                            alert('Transaksi gagal');
                        }
                        location.href='<?=site_url('sale')?>'

                    }
                })
            }            
        }        
    })




        // console.log(startDate+' Sampai '+endDate)
        // var promo = $('#multipleSelectPromo').val()
        // var doc_id = $('#invoice').text()
        // // console.log(promo)
        // var customer_id = $('#customer_id').val()
        // var subtotal = $('#sub_total').val()
        // var discount = $('#discount').val()
        // var grandtotal = $('#grand_total').val()
        // var cash = $('#cash').val()
        // var change = $('#change').val()
        // var note = $('#note').val()
        // var date = $('#date').val()

        // if(subtotal < 1){
        //     alert('Belum ada product item yang dipilih')
        //     $('#barcode').focus()
        // }else{

            // alert('Lanjut keproses selanjutnya')
            // if(confirm('Yakin proses transaksi ini?')){

            //     $.ajax({
            //         type : 'POST',
            //         url : '<?=site_url('sale/process')?>',
            //         data : {
            //                 'process_payment': true,
            //                 // 'customer_id': customer_id,
            //                 // 'subtotal': subtotal,
            //                 // 'discount': discount,
            //                 // 'grandtotal': grandtotal,
            //                 // 'cash': cash,
            //                 // 'change': change,
            //                 // 'note': note,
            //                 // 'date': date,
            //                 // 'promo':promo,
            //                 // 'doc_id':doc_id
            //                 },
            //         dataType: 'json',
            //         success: function(result){

            //             alert('Masokk')
            //             // if(result.success){
            //             //     alert('Transaksi berhasil');
            //             //     window.open('<?=site_url('sale/cetak/')?>'+result.sale_id,'_blank')
            //             // }else{
            //             //     alert('Transaksi gagal');
            //             // }
            //             // location.href='<?=site_url('sale')?>'

            //         }
            //     })
            // }
        // }


    // })
</script>