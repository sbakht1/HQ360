</div>
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?= date('Y');?> The Wireless Experience. All rights reserved.</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Design & developed by <a href="https://tekvysion.com/">TekVysion</a></span>
    </div>
</footer>
</div>
</div>
</div>


  
  
  <script defer src="<?= base_url(UI['js']); ?>/off-canvas.js"></script>
  <script defer src="<?= base_url(UI['js']); ?>/hoverable-collapse.js"></script>
  <script defer src="<?= base_url(UI['js']); ?>/misc.js"></script>
  <script defer src="<?= base_url(UI['js']); ?>/settings.js"></script>
  <script defer src="<?= base_url(UI['js']); ?>/todolist.js"></script>

  <?php if (@$_SESSION['user_data']) :?>
    <script defer src="<?= base_url(UI['vendors']); ?>/select2/select2.min.js"></script>
    <script defer src="<?= base_url(UI['vendors']); ?>/moment/moment.min.js"></script>
    <script defer src="<?= base_url(UI['main']);?>/theme/script.js"></script>
    <script defer src="<?= base_url(UI['vendors']); ?>/ag-grid/script.js"></script>
  
    <?php include 'popup.php'; ?>
    <?php if(urgent_messages() != NULL) include 'popups/urgent_messages.php'; ?>
  <?php endif;?>


</body>
</html>