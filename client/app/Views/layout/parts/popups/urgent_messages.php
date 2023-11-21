<?php 
    $msg = urgent_messages();
    $pop = ( @$_SESSION['popups'] ) ? json_encode($_SESSION['popups']): '{}';
    $noMsg = true;
?>
<style id="URGENT_CSS">
    #URGENT [data-dismiss] {display:none;}
</style>
<?= modal(['URGENT', 'lg']);?>
<div class="accordion accordion-bordered" id="acc" role="tablist">
    <?php foreach($msg as $i => $x): ?>
        <?php if (!meta_data('urgent',$x['id'])) : $noMsg=false;?>
        <div class="card" id="ur_<?=$x['id'];?>">
            <div class="card-header" role="tab" id="heading-<?= $i;?>">
                <h6 class="mb-0">
                    <a data-toggle="collapse" href="#UR<?= $i;?>" aria-expanded="false" aria-controls="UR<?= $i;?>"><?= $x['title'];?></a>
                </h6>
            </div>
            <div id="UR<?= $i;?>" class="collapse" role="tabpanel" aria-labelledby="heading-4" data-parent="#accordion-2">
                <div class="card-body"><?= $x['message'];?></div>

                <form class="ack_form">
                    <input type="hidden" name="msg_id" value="<?=$x['id'];?>">
                    <button class="btn btn-primary mb-4">Acknowledge</button>
                </form>
            </div>
        </div>
    <?php endif;?>
    <?php endforeach;?>
    
</div>
<?= ($noMsg) ? '<h4 class="text-center">No urgent message for Acknowledgement</h4>':"";?>
</div>

<?= modal();?>

<script>
    window.addEventListener 
        ? window.addEventListener('load',script,false)
        : window.attachEvent && window.attachEvent('onload',script);

function script() {
    let popups = <?=$pop;?>;
    
    let count = parseInt($('#urgentMsg .count').text());
    setTimeout(() => {
        if(isNaN(count)) {
            $('#URGENT_CSS').remove();
        } else {
            if($('body').hasClass('modal-open') == false) $('#URGENT').modal('show');
        }
    }, 2000);
    $('#URGENT').on('hide.bs.modal', function (e) {
        let count = parseInt($('#urgentMsg .count').text());
        if(!isNaN(count)) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    });
    
    if ( popups.pulse != undefined ) {
        if ( popups.pulse == true ) {
            $('#pulse').modal({backdrop:false});
            $('#pulse').modal('show');
        }
    }

    $('.ack_form').submit(function(e) {
        e.preventDefault();
        let urgent_count = $('#urgentMsg .count'),
            count = parseInt(urgent_count.text());
        $(this).after('<button class="btn btn-primary mb-4" data-dismiss="modal">Acknowledge</button>');
        $(this).remove();
        let data = $(this).serializeArray();
        $(`#ur_${data[0].value}`).remove();

        $.post(window.app.url+'/urgent',data,function(res){
            if(count != 1) {
                urgent_count.html(count-1);
            } else {
                $('#URGENT_CSS').remove();
                $('#acc').append('<h4 class="text-center">No urgent message for Acknowledgement</h4>');
                urgent_count.remove();
                $('#URGENT').modal('hide');
            }
        })
    })

    // Rating
    $('.rate').barrating({theme: 'css-stars',showSelectedRating: true});

    $('#mood').submit(function(e) {
        e.preventDefault();
        $('#mood .btn:is(button)')
            .attr('style','display:none;')
            .after(`<span class="btn btn-default mt-3"><i class="fas fa-sync fa-spin"></i> Submitting...</span>`);
        $('.err').remove();
        setTimeout(() => {
            let form = $(this).serialize(),
            send = true,
            feeling = $('#feeling').val(),
            happiness = $('#happiness').val();
            if(feeling == 0 || happiness == 0) send = false;
            if(send) {
                $.post(window.app.url+'/pulse',form,function(res) {
                    if (res) window.app.flash('success',res.msg);
                    $('#pulse').modal('hide');
                })
            } else {
                let msg = '<p class="err alert alert-fill-danger mt-3">Please Rate your <b>Happiness</b> and <b>Feelings</b> to continue...</p>';
                $('#mood').append(msg);
                $('#mood .btn:is(button)')
                    .removeAttr('style')
                    .next('span.btn').remove();
            }
        }, 1000);
    });

    let no_of_msg = $('#URGENT #acc .card').length;
    if(popups != undefined) {
        $('#pulse').on('hidden.bs.modal', function () {
            if(popups.PLE.length > 0) {
                $('#pleComliance').modal('show');
            } else {
                if (<?= count($msg);?> > 0 && no_of_msg > 0) $('#URGENT').modal('show');
            }
        });
        
        $('#pleComliance').on('hidden.bs.modal', function() {
            if (<?= count($msg);?> > 0 && no_of_msg > 0) $('#URGENT').modal('show');
        })
        
        if (popups.PLE != undefined) {
            if(popups.PLE.length > 0 && popups.pulse == undefined) $('#pleComliance').modal('show');
        }

        // if (popups.PLE == undefined && popups.pulse == undefined) {
        //     if (<?= count($msg);?> > 0 && popups.urgent_msg == 'open' && no_of_msg > 0) $('#URGENT').modal('show');
        // }
    }
}
</script>