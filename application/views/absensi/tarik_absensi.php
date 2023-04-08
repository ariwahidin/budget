<section class="content">
    <div class="box">
        <div class="box-header">
            <h4>Tarik Absensi</h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form autocomplete="off" action="<?=site_url('absensi/cek_absensi')?>" method="POST">
                        <div class="form-group">
                        <div class="form-group">
                            <label>Date range:</label>
                            <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" name="datefilter" value="" required/>
                            <input type="hidden" name="start_date">
                            <input type="hidden" name="end_date">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Cari
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    $(function() {

    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        $('input[name="start_date"]').val(picker.startDate.format('MM/DD/YYYY'));
        $('input[name="end_date"]').val(picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    });
</script>