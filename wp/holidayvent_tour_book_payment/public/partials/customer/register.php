<div class="inner">
    <form method="post">
        <?php $this->load_view_admin('customer/view/notifications.php'); ?>
        <h1>Customer Register</h1>
        <div class="form-group mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">First Name*</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control inputs" placeholder="First Name" required name="first_name">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">Last Name*</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control inputs" placeholder="Last Name" required name="last_name">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                        <input type="email" class="form-control inputs" placeholder="Email" required name="email">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">Address</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-building"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control inputs" placeholder="Address" name="billing_address_1">
                    </div>
                </div>
            </div>
        </div> 
        <div class="form-group mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">City</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-map-marker"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control inputs" placeholder="City" name="billing_city">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">State</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-map"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control inputs" placeholder="State" name="billing_state">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">Country</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-globe"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control inputs" placeholder="Country" name="billing_country">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">Zip Code</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-map-pin"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control inputs" placeholder="Zip Code" name="billing_postcode">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-4">
            <div class="row">
                <div class="col-sm-12">
                    <label class="sr-only">Telephone</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-phone"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control inputs" placeholder="Telephone" name="telephone">
                    </div>
                </div>
            </div>
        </div>       

        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="customer_register" >
                    <button type="submit" class="btn btn-submit">Register</button>
                </div>
            </div>
        </div>
    </form>

    
</div>
<script src="https://www.google.com/recaptcha/api.js?render=<?= get_captcha_key()?>"></script>
<script>
  grecaptcha.ready(function() {
      grecaptcha.execute('<?= get_captcha_key()?>', {action: 'homepage'}).then(function(token) {
      });
  });
</script>