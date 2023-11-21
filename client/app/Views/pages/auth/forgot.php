<div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <img src="<?= base_url(UI['main']);?>/images/logo-twe.png" alt="logo">
              </div>
              <h4>Forgot Password</h4>
              <form class="pt-3" method="post" id="rest_pass">
                <div class="form-group">
                  <label for="exampleInputEmail">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-envelope text-primary"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="Email" name="email">
                  </div>
                </div>
                <div class="my-3">
                  <button class="btn btn-block btn-primary btn-lg rest-btn">RESET PASSWORD</button>
                </div>
                <?php if (@$_SESSION['danger']) : ?>
                <div class="my-3">
                    <p class="alert alert-fill-danger"><i class="fa fa-exclamation-triangle"></i><?= $_SESSION['danger'];?></p>
                </div>
                <?php endif; ?>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <a href="<?= base_url('/login')?>" class="auth-link text-black">Go back to Login</a>
                </div>
              </form>
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
  $('#rest_pass').submit(function(e) {
    $('.rest-btn').attr('disabled','disabled').after('<p class="mt-3"><i class="fas fa-spin fa-sync"></i> Processing please wait...</p>');
  })
}
</script>