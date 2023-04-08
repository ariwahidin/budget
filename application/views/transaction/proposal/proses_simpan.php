<div id="muncul_modal_budget_tambahan"></div>

<script>
    function sumTotalBudget(){
        var anggaran = document.getElementsByClassName("anggaranUsed");
        var sumAnggaran = 0;
        for(var i= 0; i < anggaran.length ; i++){
            sumAnggaran += parseInt(anggaran[i].value);
        }
        $('#budget_actual').val(sumAnggaran);
        $('#budget_actual_display').val(numberWithCommas(sumAnggaran));
    }

    function getMonthUsed(){
        var monthUsed = document.getElementsByClassName("monthUsed");
        var months = [];
        for(var i = 0; i < monthUsed.length; i++){
            months.push(monthUsed[i].value);
        }
        return months;
    }


    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).ready(function(){
        sumTotalBudget();
        
    })
</script>

<script>

    $(document).on('click', '#process_payment',function(){
        simpanProses();
    })    

    function simpanProses(){

        var anggaranUsed = $('.anggaranUsed');
        var totalCosting = $('#total_costing').val();
        totalCosting = parseFloat(totalCosting.replace(/,/g, ''));

        var customers = [];
        var customerClass = $('.code_customer');
        for(var i = 0; i < customerClass.length; i++){
            customers.push(customerClass[i].value);
        }

        $brand_code = $('#brand_code').val();
        $budget_type = $('#claim').val();
        $promo_type = $('#multipleSelectPromo').val();
        var periode = $('#periode').val();
        var startDate = periode.substring(0, 10);
        var endDate = periode.substring(13, 23);
        var tabel_customer = $('#outletName').length;
        var jenis_sales = $('#AVGsls').val();
        var multiple_target = $('#multiple').val();
        var comment = $('#comment').val();
        var department = $('#department').val();
        var employee = $('#employee').val();
        var mechanismItem = $('.mec')
        var allMechanism =[]
        for(var i = 0; i < mechanismItem.length; i++){  
            var data = $(mechanismItem[i]).val()
            if(data != ''){
                allMechanism.push(data)
            }
        }

        var objItem = $('.obj')
        var allObj =[]
        for(var x = 0; x < objItem.length; x++){
            var isi = $(objItem[x]).val()
            if(isi != ''){                
                allObj.push(isi)
            }
        }
        var mechanism = allMechanism
        var objective = allObj


        var budget_tambahan = $('#budget_tambahan_value').text();
        var bulan_budget_tambahan = $('#bulan_tambahan').val();
        

        if (typeof bulan_budget_tambahan === 'undefined'){
            bulan_budget_tambahan = 0;
        }

        if(budget_tambahan == ''){
            budget_tambahan = 0;
        }else{
            budget_tambahan = budget_tambahan.replace(/,/g, '');
        }

        var budget_used = $('#budget_actual').val();
        var total_costing = $('#total_costing').val();
        total_costing = parseFloat(total_costing.replace(/,/g, ''));
        var tahun = <?=substr($start_date,6,4)?>;
        // console.log(total_costing);

        if($brand_code == ''){
            alert('Brand Kosong, Silahkan Pilih Brand')
            $('#brand_code').focus()
        }else if(anggaranUsed.length < 1){
            alert('Budget belum dipilih');
        }else if(customers == ''){
            alert('Customer Kosong')
        }else if(employee == ''){
            alert('Pic Kosong')
        }else if(department == ''){
            alert('Department Kosong')
        }else if($budget_type == ''){
            alert('Budget Type Kosong, Silahkan Pilih Budget Type')
        }else if($promo_type == ''){
            alert('Promo Type Kosong, Silahkan Pilih Promo Type')
        }else if(startDate == endDate){
            alert('Tanggal periode sama')
        }else if(mechanismItem.val() == ''){
            alert('Mechanism belum disi')
        }else if(objItem.val() == '' ){
            alert('Objective belum disi')
        }else if(jenis_sales == '' ){
            alert('Jenis sales belum dipilih, silahkan pilih jenis sales')
        }else if(multiple_target == ''){
            alert('Jenis target belum dipilih, silahkan pilih jenis target')
        }else if(comment == ''){
            alert('Comment Kosong');
        }else{

            if(anggaranUsed.length > 0){
                var nominalAnggaran = 0;
                for(var i = 0; i < anggaranUsed.length ; i++){
                    console.log(anggaranUsed[i].value);
                    nominalAnggaran += parseFloat(anggaranUsed[i].value);
                }
                console.log(nominalAnggaran);
                console.log(totalCosting);
                if(totalCosting > nominalAnggaran){
                    alert('Budget tidak cukup');
                }else{
                    $.ajax({
                    type : 'POST',
                    url: '<?=site_url('proposal/proses_simpan_transaksi')?>',
                    data: {
                        'from_sales' : '<?=$from_sales?>',
                        'customer' : customers,
                        'no_proposal' : $('#no_proposal').text(),
                        'bulan_budget_tambahan' : bulan_budget_tambahan,
                        'month_used' : getMonthUsed(),
                        'budget_brand_code' : '<?=$code_brand?>',
                        'budget_activity' : '<?=$activity?>',
                        'budget_month_used' : 1,
                        'budget_year_used' : tahun,
                        'employee' : employee,
                        'department' : department,
                        'code_brand' : $brand_code,
                        'budget_type' : $budget_type,
                        'promo_type' : $promo_type,
                        'start_date': startDate,
                        'end_date': endDate,
                        'mechanism' : mechanism,
                        'objective' : objective,
                        'jenis_sales' : jenis_sales,
                        'multiple_target' : multiple_target,
                        'comment' : comment
                    },
                    dataType:'JSON',
                    success: function(result){
                        if(result.success == true){ 
                            alert('Data Berhasil Disimpan')
                            $.ajax({
                                type: 'POST',
                                url: '<?=site_url('proposal/HapusAllCart')?>',
                                data:{},
                                dataType: 'JSON',
                                success: function(response){
                                    if(response.dell_cart_success == true){
                                        window.location.href = '<?=site_url('ProposalData')?>';
                                    }
                                }
                            });
                        }else{
                            alert('Data gagal diproses')
                        }
                    }
                })
                }
            }

        }
    }
</script>