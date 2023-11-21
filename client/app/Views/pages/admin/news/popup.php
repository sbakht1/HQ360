<?= modal(['news_modal','lg']); ?>
<h3>News & Announcement</h3>
<hr>
<form method="post" id="news_form" enctype="multipart/form-data">
    <input id="id" type="hidden" name="id" value="">
    <?= form_input(['title','Title *','text','']); ?>
    <?= form_input(['content','Content *','textarea/3','']); ?>
    <?= form_file(['media','Media','image/*','']); ?>
    <button class="btn btn-primary">SUBMIT</button>
</form>
<?= modal(); ?>
<script>
    window.addEventListener ? 
    window.addEventListener("load",script,false) : 
    window.attachEvent && window.attachEvent("onload",script);

    function script() {
            $('#content').summernote({height: 300,tabsize: 2});
            $('#news_form').validate({
                rules: {
                    title: { required: true, minlength: 5}
                }
            })
        
            $('[href="#news_modal"]').on('click',function() {
                let id = parseInt($(this).data('i')),
                    news = {id:"",title: "",content: ""};
                    if (!isNaN(id)) news = window.news[id];
                    console.log(id,news);
                    $('#content').summernote('code', news.content);
                    $('#news_form #title').val(news.title);
                    $('#news_form #id').val(news.id);
        
            })
    }
</script>