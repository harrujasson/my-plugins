<div class="inner">
    <?php $this->load_view_admin('customer/view/notifications.php'); ?>
    <form class="form-ticketsubmit" enctype="multipart/form-data" method="post">
        <h1>ACCOUNT LOGIN</h1>
        <div class="form-group mb-4">
            
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">Username*</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control inputs" name="username" placeholder="Username" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>
                        <input type="password" class="form-control inputs" placeholder="Password" required name="password">
                    </div>
                </div>
            </div>
        </div>        

        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="customer_login" >
                    <button type="submit" class="btn btn-submit">Login</button>
                </div>
            </div>
        </div>
    </form>

    <p class="links">
        <a href="#">Forget password</a> | <a href="./register.html">Don't have an account</a>
    </p>
</div>
<script src="https://www.google.com/recaptcha/api.js?render=<?= get_captcha_key()?>"></script>
<script>
  grecaptcha.ready(function() {
      grecaptcha.execute('<?= get_captcha_key()?>', {action: 'homepage'}).then(function(token) {
      });
  });
</script>