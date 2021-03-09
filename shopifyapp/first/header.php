<?php 
$shop = $_GET;
$sqlCheck = "Select * from shop WHERE store_url = '".$shop['shop']."' AND plugin = 'productview'";
$resultExist = mysqli_query($conn, $sqlCheck);

if(mysqli_num_rows($resultExist) < 1){
    header("Location: install.php?shop=".$shop['shop']);
    exit();
}else{
    $shopDB = mysqli_fetch_assoc($resultExist);
    $shop_url = $shop['shop'];
    $token = $shopDB['access_token'];
    
}


?>