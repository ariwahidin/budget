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
<div class="col-lg-3 text-center">
    <div>
        <!-- <button id="cancel_payment" class="btn btn-warning">
            <i class="fa fa-refresh"></i> Cancel
        </button> -->
        <br><br>
        <button id="process_payment" class="btn btn-flat btn-lg btn-success">
            <i class="fa fa-paper-plane-o"></i> Process
        </button>
    </div>
</div>
