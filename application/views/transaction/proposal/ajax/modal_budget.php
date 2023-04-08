<div class="modal fade" id="modal-budget" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- <h4 class="modal-title">Pilih Item</h4> -->
            </div>
            <div class="modal-body">
                <!-- <?php var_dump($months); ?> -->
                <table class="table table-bordered table-striped" id="table_budget">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Budget</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($budget->num_rows() > 0){?>
                            <?php $no=1; foreach($budget->result() as $data){ ?>
                                <tr>
                                    <td><?=getMonth($data->month)?></td>
                                    <td><?=number_format($data->nominal)?></td>
                                    <td class="text-center">
                                        <button id="choose_budget" 
                                        onClick ="use_budget(this)"
                                        data-code_brand="<?=$data->brand_code?>"
                                        data-tahun="<?=$data->tahun?>"
                                        data-bulan="<?=$data->month?>"
                                        data-month_name="<?=getMonth($data->month)?>"
                                        data-activity="<?=$data->activity?>" 
                                        data-budget="<?=$data->nominal?>" 
                                        class="btn btn-primary">Select</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                            Tidak Ada Data
                        <?php } ?>
                    </tbody>
                </table>
                     
            </div>
        </div>
    </div>
</div>
<script>
    $('#modal-budget').modal('show');

    function use_budget(d){

        var code_brand = d.getAttribute("data-code_brand");
        var tahun = d.getAttribute("data-tahun");
        var activity = d.getAttribute("data-activity");
        var bulan = d.getAttribute("data-bulan");
        var budget = d.getAttribute("data-budget");
        var month_name = d.getAttribute("data-month_name");

        tbody = document.getElementById("tbody_budget");
        const tr = document.createElement("tr");
        tr.classList.add('tr_budget');
        const td1 = document.createElement("td");

        const input = document.createElement("input");
        const type = document.createAttribute("type");
        const value = document.createAttribute("value");
        const class1 = document.createAttribute("class");


        const input2 = document.createElement("input");
        const type2 = document.createAttribute("type");
        const value2 = document.createAttribute("value");
        const class2 = document.createAttribute("class");


        var tdButton = document.createElement("td");
        tdButton.classList.add('text-center');
        var button = document.createElement("button");
        button.classList.add('btn','btn-xs','btn-danger', 'hapus_budget');
        button.setAttribute('onClick', 'deleteRowCustomer(this)');
        button.textContent = "delete";
        tdButton.appendChild(button);


        type.value = "hidden";
        value.value = bulan;
        class1.value = "monthUsed";

        type2.value = "hidden";
        value2.value = budget;
        class2.value = "anggaranUsed";


        input.setAttributeNode(type);
        input.setAttributeNode(value);
        input.setAttributeNode(class1);


        input2.setAttributeNode(type2);
        input2.setAttributeNode(value2);
        input2.setAttributeNode(value2);
        input2.setAttributeNode(class2);

        var td2 = document.createElement("td");
        td1.textContent = month_name;
        td1.appendChild(input);

        td2.textContent = numberWithCommas(budget);
        td2.appendChild(input2);

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(tdButton);

        tbody.appendChild(tr);


        $('#modal-budget').modal('hide');
        disableButton();
        }

        function deleteRowCustomer(r) {
            var i = r.parentNode.parentNode.rowIndex;
            document.getElementById("table_budget_used").deleteRow(i);
            enableButton();
        }

        function disableButton(){
            var tr_budget = $('.tr_budget');
            if(tr_budget.length > 0){
                var btnBGT = $('#get_budget');
                // console.log(btnBGT[0].disabled);
                if(btnBGT[0].disabled == false){
                    btnBGT[0].disabled = true;
                }
                // alert('budget sudah di set');
            }
        }

        function enableButton(){
            var btnBGT = $('#get_budget');
            if(btnBGT[0].disabled == true){
                btnBGT[0].disabled = false;
            }
                
        }

</script>
