<?php 
include_once 'inc/functions.php';
include_once 'inc/sql_connection.php';

$id = $_POST['id'];
$shop_url = $_POST['shopUrl'];

$sql = "Select * from shop WHERE store_url = '".$shop_url."'";
$resultExist = mysqli_query($conn, $sql);
if(mysqli_num_rows($resultExist) > 0){
    $shopDB = mysqli_fetch_assoc($resultExist);
    $token = $shopDB['access_token'];
    
    
    if($_POST['type'] == "GET"){
        $prodcucts = shopify_call($token,$shop_url,'/admin/api/2020-07/products/'.$id.'.json',array(),'GET');
        $prodcucts = json_decode($prodcucts['response'],JSON_PRETTY_PRINT);

        $id = $prodcucts['product']['id'];
        $title = $prodcucts['product']['title'];
        $description = $prodcucts['product']['body_html'];
        $collections = array();

        $custom_collections = shopify_call($token,$shop_url,'/admin/api/2020-07/custom_collections.json',array('product_id'=>$id),'GET');
        $custom_collections = json_decode($custom_collections['response'],JSON_PRETTY_PRINT);

        foreach($custom_collections as $custom_collection){
            foreach($custom_collection as $key=>$value){
                array_push($collections, array("id"=>$value['id'],'name'=>$value['title']));
            }
        }

        $smart_collections = shopify_call($token,$shop_url,'/admin/api/2020-07/smart_collections.json',array('product_id'=>$id),'GET');
        $smart_collections = json_decode($smart_collections['response'],JSON_PRETTY_PRINT);

        foreach($smart_collections as $smart_collection){
            foreach($smart_collection as $key=>$value){
                array_push($collections, array("id"=>$value['id'],'name'=>$value['title']));
            }
        }

        echo json_encode(array( "id"=>$id, "title"=>$title,"description"=>$description,"collections"=>$collections));
    }else{
        $prodctData = array();
        parse_str($_POST['formdata'],$prodctData);
        
        $arraySubmit = array(
            'product' => array(
                "title" => $prodctData['title'],
                "body_html" => $prodctData['description']
            )
        );
        
        $prodcucts = shopify_call($token,$shop_url,'/admin/api/2020-07/products/'.$id.'.json',$arraySubmit,'PUT');
        
    }
    
    
}

?>

