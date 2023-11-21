<?php 
    $role = user_data('Title')[1];
    $year = (@$_GET['year']) ? $_GET['year'] : date('Y');
    $type = (@$_GET['type']) ? $_GET['type'] : "employee";
?>
<style>
    .actions .form-group {margin:0;display:inline-block;min-width:150px;}
</style>
<script>
    window.app.score = '/<?= user_data('Title')[1];?>/scorecards/find?year=<?=$year;?>';
</script>
<div class="actions">
    <div class="form-group">
        <select name="year" id="year" class="select2">
            <?php for($y=date('Y'); $y >= date('Y',strtotime('-5 years'));$y--) : ?>
                <option <?= ($year == $y)? "selected":"";?> value="<?=$y;?>"><?=$y;?></option>
            <?php endfor;?>
        </select>
    </div>
</div>


<?= card('start');?>
<div id="scoreGrid" class="ag-theme-alpine my-grid"></div>
<?= card('end');?>

<?= modal(['scorecard','lg']);?>
    <div id="stage"></div>
<?= modal();?>

<script defer src="<?=base_url(UI['main']);?>/ag-grid/scorecard.js"></script>
<script defer src="<?=base_url(UI['theme']);?>/scorecard.js"></script>