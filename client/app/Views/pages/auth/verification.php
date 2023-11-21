<style>
  .error {width:100%;}
</style>
<div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <img src="<?= base_url(UI['main']);?>/images/logo-twe.png" alt="logo">
              </div>
            <?php if($reset) : ?>
              <form action="<?= current_url()."?".$_SERVER['QUERY_STRING'];?>" class="pt-3" id="rest_form" method="post">
              <div class="form-group">
                  <label for="un">Username</label>
                  <p><strong><?=@$info->username;?></strong></p>
                </div>

                <div class="form-group">
                  <label for="password">Reset Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-key text-primary"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-left-0" id="password" placeholder="Enter passwrd" name="password">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-key text-primary"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-left-0" id="confirm_password" placeholder="Enter confirm passwrd" name="confirm_password">
                  </div>
                </div>
                <div class="my-3 form_submit">
                  <button class="btn btn-block btn-primary btn-lg">Set Password</button>
                </div>
                <?php if (@$_SESSION['danger']) : ?>
                <div class="my-3">
                    <p class="alert alert-fill-danger"><i class="fa fa-exclamation-triangle"></i><?= $_SESSION['danger'];?></p>
                </div>
                <?php endif; ?>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <a href="<?= base_url('/login')?>" class="auth-link text-black">Go to Login</a>
                </div>
              </form>
              <?php else: ?>
                <h4><?= $msg;?></h4>
              <?php endif;?>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; <?=date('Y');?>  All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
  
<script>
  window.addEventListener
        ? window.addEventListener('load', script,false)
        : window.attachEvent && window.attachEvent('onload', script);

function script() {
  $('#rest_form').submit(function(e) {
    e.preventDefault();
    let ps = $('#password'),
        cp = $('#confirm_password'),
        ac = $(this).attr('action'),
        fd = $(this).serialize(),
        go = true;

    $('#rest_form .error').remove();
    if( ps.val().length < 6) {
      go = false;
      ps.after('<span class="error text-danger">This must have at least 6 character.</span>')
    }
    if(cp.val() !== ps.val()) {
      go = false;
      cp.after(`<span class="error text-danger">Password did not match.</span>`)
    }

    console.log(ac,fd,go);

    if(go) {
      $.post(ac,fd,function(res) {
        if(res.success) {
          $('.form_submit').after(`<div class="my-3">
                <p class="alert alert-fill-success"><i class="fa fa-check"></i> Your password has been set.</p>
          </div>`);
          setTimeout(function() {
            window.open('<?= base_url('/login');?>','_self');
          },3000)
        }
      })
    }
  })
}
</script>