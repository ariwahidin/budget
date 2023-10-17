<?php $this->view('header') ?>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>Data Purchase</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped table_purchase">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <!-- <th>Code Brand</th> -->
                                    <th>Brand Name</th>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($purchase->result() as $key => $p) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <!-- <td><?= $p->CodeBrand ?></td> -->
                                        <td><?= $p->BRAND ?></td>
                                        <td><?= $p->Year ?></td>
                                        <td><?= $p->month ?></td>
                                        <td><?= number_format($p->Amount) ?></td>
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
<?php $this->view('footer') ?>
<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('.table_purchase thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('.table_purchase thead');

        var table = $('.table_purchase').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            initComplete: function() {
                var api = this.api();
                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" placeholder="' + title + '" />');

                        // On every keypress in this input
                        $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                            .off('keyup change')
                            .on('change', function(e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != '' ?
                                        regexr.replace('{search}', '(((' + this.value + ')))') :
                                        '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function(e) {
                                e.stopPropagation();
                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            },
        });
    });
</script>