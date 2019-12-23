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
        <div class="section-title">
            <h2>Payment</h2>
            <p>Transaction status.</p>
            <hr class="center">
        </div>
        <div class="contact-right-2">

            <div id="loadingAlert" class="" style="display: none;">
                <div class=""role="alert">
                    Loading....
                </div>
            </div>
            <form id="orderConfirm"
                class="form-horizontal"
                style="display: none;">
                <h3>Your payment is authorized.</h3>
                <h3>Confirm the payment to execute</h3>
                <hr>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Shipping Information</label>
                    <div class="col-sm-7">
                        <p id="confirmRecipient"></p>
                        <p id="confirmAddressLine1"></p>
                        <p id="confirmAddressLine2"></p>
                        <p>
                            <span id="confirmCity"></span>,
                            <span id="confirmState"></span> - <span id="confirmZip"></span>
                        </p>
                        <p id="confirmCountry"></p>
                    </div>
                </div>                   

                <div class="form-group">
                    <div class="col-sm-offset-5 col-sm-7">
                        <label class="btn btn-primary" id="confirmButton">Complete Payment</label>
                    </div>
                </div>
            </form>

            <!--Customize html-->
            <div id="orderView" class="form-horizontal" style="display: none;">                   
                <h4 style="text-align: center; margin-top: 10px;">                      
                    Thank you for payment                    
                </h4>
                <hr>
                <div class="form-group">

                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                        <label class="control-label head_label"><h5>Transaction Details</h5></label>
                        <p class="text_heighlight reciept">Transaction Status: <span id="viewPaymentState"></span></p>
                        <p class="text_heighlight reciept">Transaction Payee ID: <span id="viewTransactionPayeeID"></span></p>
                        <p class="text_heighlight reciept">Transaction ID: <span id="viewTransactionID"></span></p>                        
                        <p class="reciept">Invoice ID: <span id="viewTransactionInvoiceID"></span></p>
                        <p class="reciept">Payment Total Amount: <span id="viewFinalAmount"></span> </p>
                        <br>
                        <p class="m-t-10 muted">Save the <span class="text_heighlight">Transaction Payee ID/Transaction ID</span> for future enquiry, regarding transaction.</storng></p>
                    </div>
                </div>
            </div>




            <div id="orderFail" class="form-horizontal" style="display: none;">                   
                <h4 style="text-align: center; margin-top: 10px;">                      
                    Transaction Failed. Please try after some              
                </h4>
                <hr>
                <div class="form-group">

                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                        <label class="control-label head_label"><h5>Transaction Details</h5></label>
                        <p class="text_heighlight reciept">Transaction Status: <span id="viewPaymentStateFail"></span></p>
                        <p class="text_heighlight reciept">Transaction Payee ID: <span id="viewTransactionPayeeIDFail"></span></p>                                     
                        
                        <br>
                        <p class="m-t-10 muted">Save the <span class="text_heighlight">Transaction Payee ID/Transaction ID</span> for future enquiry, regarding transaction.</storng></p>
                    </div>
                </div>
            </div>
            
            <!--End customize-->

        </div>
    </div>  
</div>
@stop
@section('footer_scripts')
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script src="{{asset('public/js/config_paypal.js') }}"></script>
<script type="text/javascript">

    let inputParams = {
        "pay_id": '{{$paymentId }}',
        "payer_id": '{{$PayerID}}'
    };
    add_payid();
    showDom('loadingAlert');
    paypal.request.post(
        '<?= $baseUrl.$URL['services']['paymentGet'] ?>',
        inputParams
    ).then(function (response) {
       
        hideDom('loadingAlert');
        if (response.ack) {
            if(getUrlParams('commit') === 'true') {
                showPaymentExecute(response.data);
            }
            else {
                showPaymentGet(response.data);
            }
        }
        else
            alert("Something went wrong");
    });

    function showPaymentGet(res) {        
        let shipping = res.payer.payer_info.shipping_address;

        document.getElementById('confirmRecipient').innerText = shipping.recipient_name;
        document.getElementById('confirmAddressLine1').innerText = shipping.line1;
        if(shipping.line2)
            document.getElementById('confirmAddressLine2').innerText = shipping.line2;
        else
            document.getElementById('confirmAddressLine2').innerText = "";
        document.getElementById('confirmCity').innerText = shipping.city;
        document.getElementById('confirmState').innerText = shipping.state;
        document.getElementById('confirmZip').innerText = shipping.postal_code;
        document.getElementById('confirmCountry').innerText = shipping.country_code;

        showDom('orderConfirm');

        // Listen for click on confirm button
        document.querySelector('#confirmButton').addEventListener('click', function () {
            

            let postData = {
                    "pay_id": res.id,
                    "payer_id": res.payer.payer_info.payer_id,
                    "item_amt": res.transactions[0].amount.details.subtotal,
                    "tax_amt": res.transactions[0].amount.details.tax,
                    "handling_fee": res.transactions[0].amount.details.handling_fee,
                    "insurance_fee": res.transactions[0].amount.details.insurance,
                    "shipping_discount": res.transactions[0].amount.details.shipping_discount,
                    "total_amt": res.transactions[0].amount.total,
                    "currency": res.transactions[0].amount.currency,
                    "updated_shipping": 0,
                    "current_shipping": res.transactions[0].amount.details.shipping
                };

            // Execute the payment
            hideDom('confirmButton');
            showDom('loadingAlert');
            paypal.request.post(
                '<?= $baseUrl.$URL['services']['paymentExecute'] ?>',
                postData
            ).then(function (res) {
                hideDom('orderConfirm');
                hideDom('loadingAlert');
                if (res.ack)
                    showPaymentExecute(res.data);
                else
                    alert("Something went wrong");
            });
        });
    }

    function showPaymentExecute(result) {   
   
        if(result.state =="approved"){
            
            let payerInfo = result.payer.payer_info;
            document.getElementById('viewTransactionID').textContent = result.transactions[0].related_resources[0].sale.id;        
            document.getElementById('viewTransactionPayeeID').textContent ='{{$paymentId}}';
            document.getElementById('viewFinalAmount').textContent = result.transactions[0].amount.total;           
            document.getElementById('viewPaymentState').textContent = result.transactions[0].related_resources[0].sale.state;          
            document.getElementById('viewTransactionInvoiceID').textContent = result.transactions[0].invoice_number; 
            showDom('orderView');
        }else{
            console.log("Total "+result.transactions[0].amount.total);
            showDom('orderFail');
            hideDom('orderView');
            document.getElementById('viewTransactionPayeeIDFail').textContent ='{{$paymentId}}';                    
            document.getElementById('viewPaymentStateFail').textContent = result.state;           
            
        }
        

        hideDom('orderConfirm');
        hideDom('loadingAlert');
        //showDom('orderView');
        status_update();
    }
    
    
    function status_update(){
        $.ajax({
            type:"post",
            data:"payid="+getUrlParams('paymentId'),
            url:"{!! route("payment.update_status") !!}",
            success:function(data){                
            }
            
        });
    }
    function add_payid(){
        $.ajax({
            type:"post",
            data:"payid="+getUrlParams('paymentId'),
            url:"{!! route("payment.update_payid") !!}",
            success:function(data){                
            }
            
        });
    }
    
    
</script>
@stop
