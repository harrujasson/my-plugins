<?php $this->load_view_admin('customer/view/sidebar.php'); ?>
<div class="col-md-9">
    <div class="inner viewPageBox pt-0">
        <div id="wrap">
            <div class="row">
                <div class="col-12">
                    <div id="page-heading">
                        <ol class="breadcrumb">
                        <li><a href="<?=site_url('customer-account')?>">Dashboard</a></li>
                        <li class="active">My Profile</li>
                    </ol>

                    <h1>My Profile</h1>
                    <?php $this->load_view_admin('customer/view/notifications.php'); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <img src="assets/demo/avatar/johansson.png" alt="" class="pull-left" style="margin: 0 20px 20px 0">
                                    <div class="table-responsive">
                                        <h3><strong><?=$r->display_name?></strong></h3>
                                        <table class="table table-condensed">
                                            <tbody>
                                                <tr>
                                                    <td>Username</td>
                                                    <td><?=$r->user_login?></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td><?=$r->user_email?></td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td><?=$call->get_user_field($r->ID,'billing_phone')?></td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td><?=$call->get_user_field($r->ID,'billing_address_1')?></td>
                                                </tr>
                                                <tr>
                                                    <td>City</td>
                                                    <td><?=$call->get_user_field($r->ID,'billing_city')?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>State</td>
                                                    <td><?=$call->get_user_field($r->ID,'billing_state')?></td>
                                                </tr>
                                                <tr>
                                                    <td>Country</td>
                                                    <td><?=$call->get_user_field($r->ID,'billing_country')?></td>
                                                </tr>
                                                <tr>
                                                    <td>Zip Code</td>
                                                    <td><?=$call->get_user_field($r->ID,'billing_postcode')?></td>
                                                </tr>
                                                <tr>
                                                    <td>Member As</td>
                                                    <td>Customer</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container -->
    </div>
</div>