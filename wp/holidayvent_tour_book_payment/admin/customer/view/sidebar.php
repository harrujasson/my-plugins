<div class="col-md-3 left">
    <ul>
        <li>
            <a href="<?=site_url('customer-account/profile')?>" class="">
                <i class="fas fa-user"></i>
                My Profile
            </a>
        </li>

        <li>
            <a href="<?=site_url('customer-account')?>" class="">
                <i class="fas fa-shopping-cart"></i>
                My Tour/Order
            </a>
        </li>

        <li>
            <a href="<?= wp_logout_url('customer-account-login') ?>">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </li>
    </ul>
</div>