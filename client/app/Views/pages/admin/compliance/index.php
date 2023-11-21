<?php $role = user_data('Title')[1];?>

<?= card('start');?>
<div id="Grid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>


<script defer="defer" src="<?= base_url(UI['main']."/ag-grid/compliance.js");?>"></script>

<script>
    window.addEventListener
        ?window.addEventListener('load',script,false)
        :window.attachEvent && window.attachEvent('onload',script);
    function script() {}
</script>