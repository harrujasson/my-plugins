@extends('layouts.front_inner')
@section('header_extra')
<!--Write here extra style-->
@stop
@section('banner')
<div class="span-title">
    <h1>Direct Payment</h1>
</div>	
@stop
@section('content')
<div class="main">
            <div class="section">
<!--                <div class="section-title">
                    <h2>Payment</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
                    <hr class="center">
		</div>-->
                <div class="contact-right-2">
                    <form id="contact-form" method="post" action="#">
                        <div class="messages"></div>
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="form_name" type="text" name="customer_name" class="form-control customize" placeholder="Name" required="required" data-error="Name is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="form_email" type="email" name="email" class="form-control customize" placeholder="Email address" required="required" data-error="Valid email is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="form_phone" type="tel" name="phone" class="form-control customize" placeholder="Please enter your phone">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="form_address" type="text" name="address" class="form-control customize" placeholder="Please enter your complete address">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" id="form_message" name="message" class="form-control customize" placeholder="Your message" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="regarding_payment" class="form-control customize" placeholder="Please enter your payment type. Example: Project payment,Outstanding payment, etc">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="form_address" type="number" step="0.10" min="1" name="amount" class="form-control customize" placeholder="Amount(Should be in USD)" required="required" data-error="Amount should be greater then 0.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row m-b-20">
                                <div class="col-md-12">                                    
                                    <p>
                                        <img src="https://fpdbs.paypal.com/dynamicimageweb?cmd=_dynamic-image&amp;buttontype=ecmark&amp;locale=en_US" alt="Acceptance Mark" class="v-middle">
                                        <a href="https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, ,left=0, top=0, width=400, height=350'); return false;">What is PayPal?</a>                                    
                                    </p>                                   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-4 col-xs-12">                                    
                                    <div id="paypalCheckoutContainer"></div>
                                </div>
                            </div>                            
                        </div>
                    </form>
                </div>
            </div>  
        </div>
@stop
@section('footer_scripts')
<script src="{{asset('public/front/js/validator.js')}}" type='text/javascript'></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script src="{{asset('public/js/config_paypal.js') }}"></script>
<script type="text/javascript">
$('#contact-form').validator();
    paypal.Button.render({
        
        // Set your environment
        env: '<?= $PAYPAL_ENVIRONMENT ?>',

        // Set style of button
        style: {
            layout: 'horizontal',   // horizontal | vertical
            size:   'responsive',    // medium | large | responsive
            shape:  'pill',      // pill | rect
            color:  'gold'       // gold | blue | silver | black
        },

        // Set allowed funding sources
        funding: {
            allowed: [
                paypal.FUNDING.CARD,
                paypal.FUNDING.CREDIT
            ],
            disallowed: [ ]
        },

        // Execute payment on authorize
        commit: true,

        // Wait for the PayPal button to be clicked
        payment: function() {
            if($("input[name='customer_name']").val()==""){
                $("input[name='customer_name']").parent().addClass('has-error');
                return false;
            }
            if($("input[name='email']").val()==""){
                $("input[name='email']").parent().addClass('has-error');
                return false;
            }
            if($("input[name='amount']").val()==""){
                $("input[name='amount']").parent().addClass('has-error');
                return false;
            }
           
                postData = {
                    "item_amt": $("input[name='amount']").val(),
                    "customer_name":$("input[name='customer_name']").val(),
                    "email":$("input[name='email']").val(),
                    "phone":$("input[name='phone']").val(),
                    "address":$("input[name='address']").val(),
                    "message":$("input[name='message']").val(),
                    "amount":$("input[name='amount']").val(),
                    "regarding_payment":$("input[name='regarding_payment']").val(),
                    "tax_amt": 0,
                    "handling_fee": 0,
                    "insurance_fee": 0,
                    "shipping_amt": 0,
                    "shipping_discount": 0,
                    "total_amt": $("input[name='amount']").val(),
                    "currency": "GBP",
                    "return_url": '<?= $baseUrl.$URL["redirectUrls"]["returnUrl"]?>' + '?commit=true',
                    "cancel_url": '<?= $baseUrl.$URL["redirectUrls"]["cancelUrl"]?>',
                    "shipping_recipient_name": 'Jack',                    
                    "shipping_city": 'New York',
                    "shipping_state": 'NY',
                    "shipping_postal_code": '10022',
                    "shipping_country_code": 'US'
                };

            return paypal.request.post(
                '<?= $baseUrl.$URL['services']['paymentCreate'] ?>',
                postData
            ).then(function(res) {
                return res.data.id;
            });
        },

        // Wait for the payment to be authorized by the customer
        onAuthorize: function(data, actions) {

            let postData = {
                "pay_id": data.paymentID,
                "payer_id": data.payerID
            };

            // Execute Payment
            return paypal.request.post(
                '<?= $baseUrl.$URL['services']['paymentExecute'] ?>',
                postData
            ).then(function() {
                actions.redirect();
            });
        },

        // Handle cancelled payment by the customer
        onCancel: function(data, actions) {
            actions.redirect();
        }

    }, '#paypalCheckoutContainer');

</script>    

@stop
