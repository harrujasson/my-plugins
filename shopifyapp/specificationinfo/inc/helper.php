<?php 
include 'sql_connection.php';
$shop = $_GET;
$shop_url = $shop['shop'];
//echo "Shop URL ".$shop_url;
$token = get_token_save($shop,$conn);

function get_token_save($shop,$conn){
    $sqlCheck = "Select * from shop WHERE store_url = '".$shop['shop']."' AND plugin = 'specification' ";
    $resultExist = mysqli_query($conn, $sqlCheck);
    if(mysqli_num_rows($resultExist) < 1){
        header("Location: install.php?shop=".$shop['shop']);
        exit();
    }else{
        $shopDB = mysqli_fetch_assoc($resultExist);
        $token = $shopDB['access_token'];
        return $token;
    }  
}


?>