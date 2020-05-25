<?php

function get_instance(){
    $obj = new MWPL_Super_Loader();
    return $obj;
}
function get_captcha_key(){
    $ci = get_instance();
    $record  = get_general_settings_all();
    if(isset($record->g_captcha_code)) {
        return $record->g_captcha_code;
    }
}
function get_general_settings_all(){
    global $wpdb;
    $table_settings = $wpdb->prefix."mwpl_settings";
    $ci = get_instance();
    $general_seting = $ci->get_record_by_row($table_settings, array("type"=>"admin",'service'=>"general"));  
    if(!empty($general_seting)){
       if($general_seting->information!=""){
            return json_decode($general_seting->information);
        } 
    }
}
function get_email_settings_all(){
    global $wpdb;
    $table_settings = $wpdb->prefix."mwpl_settings";
    $ci = get_instance();
    $general_seting = $ci->get_record_by_row($table_settings, array("type"=>"admin",'service'=>"email"));  
    if(!empty($general_seting)){
       if($general_seting->information!=""){
            return json_decode($general_seting->information);
        } 
    }
}
function get_order_status($status=''){
    switch ($status){
        case 1:
            return "Reviewing";
            break;
        case 2:
            return "Processing";
            break;
        case 3:
            return "Completed";
            break;
        case 4:
            return "Cancelled";
            break;
        case 5:
            return "Refund";
            break;
    }
}

/*CCavenue methods*/
function encrypt($plainText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	$encryptedText = bin2hex($openMode);
	return $encryptedText;
}

/*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
function decrypt($encryptedText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText = hextobin($encryptedText);
	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	return $decryptedText;
}

function hextobin($hexString) 
 { 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
	    
	    else 
	    {
			$binString.=$packedString;
	    } 
	    
	    $count+=2; 
	} 
        return $binString; 
  } 
?>
