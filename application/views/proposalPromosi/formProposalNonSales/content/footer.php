<script type="text/javascript">
    function calculate_grand_total_costing(){
        var inputGrandTotalCosting = document.getElementById('grand_total_costing');
        var grandTotalCosting = 0;
        var subtotalTotalCosting = document.getElementById('subtotalTotalCosting').value;
        var totalItemAdd = document.getElementById('total_item_add').value;

        if(totalItemAdd == ''){
            totalItemAdd = 0;
        }else if(subtotalTotalCosting == ''){
            subtotalTotalCosting = 0;
        }

        grandTotalCosting = parseFloat(subtotalTotalCosting) + parseFloat(totalItemAdd);
        inputGrandTotalCosting.value = grandTotalCosting //.toLocaleString();
        // inputGrandTotalCosting.value = 55000000;
    }
</script>