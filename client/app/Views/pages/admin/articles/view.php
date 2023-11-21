<link rel="stylesheet" href="<?= base_url(UI['main']); ?>/vendors/summernote/dist/summernote-bs4.css"/>
<style>
    .status {min-width: 300px;}
</style>
<form method="post" id="news_form" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-9">
        <?=card('start');?>        
                <input id="id" type="hidden" name="id" value="<?= $id; ?>">
                <?= form_input(['title','Title *','text',@$article['title']]); ?>
                <?= form_input(['content','Content *','textarea/3',@$article['content']]); ?>
                <div class="d-flex align-items-center">
                    <div class="status">
                        <?= select2(['status','Status',['Publish','Draft'],@$article['status']]);?>
                    </div>
                    <div class="button ml-3">
                        <button class="btn btn-lg btn-primary">SUBMIT</button>
                    </div>
                </div>
                <?=card('end');?>        
            </div>
            <div class="col-md-3">
                <?= card('start'); ?>
                <div id="cats"></div>
                <div class="form-group">
                    <div class="form-group">
                        <input type="text" name="cat" id="cat" class="form-control" placeholder="Type Category...">
                        <select name="pc" id="pc" class="form-control my-3"></select>
                        <a id="cat_sub" class="btn btn-primary">Add Category</a>
                    </div>
                </div>
                <?= card('end'); ?>
            </div>
        </form>
</div>
<script defer src="<?= base_url(UI['main']); ?>/vendors/summernote/dist/summernote-bs4.min.js"></script>
<script>
if (window.addEventListener) window.addEventListener("load",script,false);
function script() {
        $('#content').summernote({height: 300,tabsize: 2});
        $('#news_form').validate({rules: {title: { required: true, minlength: 5}}})
        $('#news_form').submit(function(e) {
            e.preventDefault();

            let empty = $('#content').summernote('isEmpty');

            (empty) 
                ? $('#error_content').html('This field is required.')
                : $('#news_form')[0].submit();
        })


        // categories
        let c = [],
            sc = '<?= @$article['category'];?>';
        $.post('<?= current_url(); ?>',{type:'category'}, function(res) {
            c = res;
            dc();
        })

        function dc() {
            $('#cats').html('');
            $('#pc').html('<option value="0">Parent Category</option>');
            for( x of c) if (x.parent == 0){
                $('#cats').append(gen_inp(x,""));
                $('#pc').append(`<option value="${x.id}">${x.name}</option>`);
            }
            for( x of c) if (x.parent != 0) {
                $(`#cats #i${x.parent}`).after(gen_inp(x,"4"));
            }

            if (sc == "") sc = c[0].id;
            $(`#cats [value="${sc}"]`).trigger('click');
            $('#cats input').on('click', function() {sc = $(this).val();});
        }

        

        function gen_inp(x,xc) {
            return `<div class="form-check mb-2 ml-${xc}" id="i${x.id}">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="category" value="${x.id}">${x.name}<i class="input-helper"></i></label>
                </div>`;
        }

        $('#cat_sub').on('click', update_cat);

        function update_cat() {
            let data = {name: $('#cat').val(),parent: $('#pc').val(),type:'category'};
            if ( $('#cat').val() !== "") {
                $.post('<?= current_url();?>',data,function(res){
                    $('#cat').val('');
                    c = res;
                    dc();
                })
            }
        }
    }
</script>