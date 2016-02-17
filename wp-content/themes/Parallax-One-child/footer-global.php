<div class="modal fade modal-login" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content text-center">
      <div><?php echo do_shortcode('[login_widget title="Log in"]'); ?></div>
    </div>
  </div>
</div>

<div class="modal fade modal-forget-password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content text-center">
      <div><?php echo do_shortcode('[forgot_password title="Forgot Password?"]'); ?></div>
    </div>
  </div>
</div>

<div class="modal fade modal-signup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content text-center">
      <h2>Sign up</h2>
      <div class="form-wrapper">
        <div><?php echo do_shortcode('[user-meta-registration form="signup"]'); ?></div>
      </div>
      <div class="footer">
        <div>Already signed up? <a href="login" class="js-login-redirect" data-toggle="modal" data-target=".modal-login">Log in</a></div>
        <div><a href="login" class="js-login-redirect" data-toggle="modal" data-target=".modal-forget-password">Forgot your password?</a></div>
      </div>

    </div>
  </div>
</div>
