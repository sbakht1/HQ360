<style>
    .actions label {display:none;}
    .actions .form-group {margin:0;}
</style>
<div class="actions text-right">
    <form id="monthForm" action="<?= current_url();?>">
        <?= form_input(['month','Month','month',$month]);?>
    </form>
</div>
<div class="card">
    <div class="card-body">
    <table class="table">
    <thead>
    <tr>
        <th>Date</th>
        <th>Category</th>
        <th>Detail</th>
     </tr>
    </thead>
    <tbody>
       

    <?php if(!empty($view_all_notes['data'])) : ?>
    <?php foreach($view_all_notes['data'] as $k =>$v): ?>
            <tr>
              <td><span class="moment" data-time="<?=$v['created']?>" data-form="lll"></span></td>
              <td><?=$v['category']?></td>
              <td><?=$v['detail']?></td>
            </tr> 
       <?php endforeach; endif; ?>  
      </tbody>
    </table>
   </div>
  </div>
  <?= $view_all_notes['links']; ?> 
</div>
</div>
<script>
  window.addEventListener 
    ? window.addEventListener('load',script) 
    : window.attachEvent && window.attachEvent('onload',script,false);
  function script() {
    $('#month').on('change', function() {
      $('#monthForm').submit();
    })
  }
</script>
