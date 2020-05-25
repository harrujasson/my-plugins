<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.maansawebworld.com/
 * @since      1.0.0
 *
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/Library
 * @author     Talwinder Singh <maansawebworldphp@gmail.com>
 */
class MWPL_Ccavenue {
    /*Holidayvent Test*/
    private $working_key ='1514A8118AA944ED4BA9FEC2928CEC20';
    private $access ='AVZX02GJ95CK10XZKC';
    /*Localhost*/
//    private $working_key ='ACD214E69464ED0521CBAB9DB520E465';
//    private $access ='AVBI02GJ95CL12IBLC';
    private $mode ='test';
    //private $mode ='secure';
    private $merchant_id= '235790';
    private $role;
    private $userid;
    private $billing_name='';
    private $billing_address='';    
    private $billing_city='';
    private $billing_state='';
    private $billing_zip='';
    private $billing_country='';
    private $billing_tel='';
    private $billing_email='';
    private $redirect_url = '';
    private $cancel_url ='';
    
    use MWPL_Roles;
    function __construct($user_id=0){
        $this->redirect_url = site_url('payment-response');
        $this->cancel_url = site_url('payment-cancel');
        $this->role = $role;
        $this->userid =  $user_id;
        $this->billing_name = $this->get_user_field($this->userid);
        $this->billing_address = $this->get_user_field($this->userid,'billing_address_1');
        $this->billing_city = $this->get_user_field($this->userid,'billing_city');
        $this->billing_state = $this->get_user_field($this->userid,'billing_state');
        $this->billing_zip = $this->get_user_field($this->userid,'billing_postcode');
        $this->billing_country = $this->get_user_field($this->userid,'billing_country');
        $this->billing_tel = $this->get_user_field($this->userid,'billing_phone');
        $this->billing_email = $this->get_user_field($this->userid,'user_email');
    }
    
    function set_fields($order_id=0,$amount=''){
        $merchant_data='';
        $data['merchant_id'] = $this->merchant_id;
        $data['order_id'] = $order_id;
        $data['currency'] = 'INR';
        $data['amount'] = $amount;
        $data['redirect_url'] = $this->redirect_url;
        $data['cancel_url'] = $this->cancel_url;
        $data['language'] = 'en';
        $data['billing_name'] = $this->billing_name;
        $data['billing_address'] = $this->billing_address;
        $data['billing_city'] = $this->billing_city;
        $data['billing_state'] = $this->billing_state;
        $data['billing_zip'] = $this->billing_zip;
        $data['billing_country'] = $this->billing_country;
        $data['billing_tel'] = $this->billing_tel;
        $data['billing_email'] = $this->billing_email;
       
        foreach ($data as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}
	$encrypted_data=encrypt($merchant_data, $this->working_key); // Method for encrypting the data.        
        return $this->send_call($encrypted_data); 
    }
    function response_get(){
        $data_status = array();
        $encResponse=$_POST["encResp"];
        $rcvdString=decrypt($encResponse, $this->working_key);
        $order_status="";
        $decryptValues=explode('&', $rcvdString);
        $dataSize=sizeof($decryptValues);
        for($i = 0; $i < $dataSize; $i++) {	
		$information=explode('=',$decryptValues[$i]);
		if($i==3) $order_status=$information[1];
	}
        if($order_status==="Success"){
            $data_status['message'] = "Thank you for purchase the tour";
            $data_status['code']=1;
	}
	else if($order_status==="Aborted"){
            $data_status['message']= "Thank you for purchase the tour with us.We will keep you posted regarding the status of your order through e-mail";
            $data_status['code']=2;
	
	}
	else if($order_status==="Failure"){	
            $data_status['message']= "Thank you for purchase the tour with us.However,the transaction has been declined.";
            $data_status['code']=3;
	}
	else{
            $data_status['message']= "Security Error. Illegal access detected";
            $data_status['code']=4;
	
	}
        
        for($i = 0; $i < $dataSize; $i++) {	
		$information=explode('=',$decryptValues[$i]);
                $data_status['response'][$i][$information[0]] = $information[1];	    	
	}
        return $data_status;
    }
    function send_call($encrypted_data=''){ ?>
        <form method="post" name="redirect" action="https://<?= $this->mode?>.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
            <?php
            echo "<input type=hidden name=encRequest value=$encrypted_data>";
            echo "<input type=hidden name=access_code value=$this->access>";
            ?>
        </form>
        <script language='javascript'>document.redirect.submit();</script>
        <?php
    }
    
}
?>