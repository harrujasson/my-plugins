<?php 
echo "Script add in theme footer ".$token .' '.$shop_url.'<br>';
$theme = shopify_call($token,$shop_url,"/admin/api/2021-01/themes.json",array(),'GET');
$theme = json_decode($theme['response'],JSON_PRETTY_PRINT);
foreach($theme as $cur_theme){
    foreach($cur_theme as $key=> $value){
        if($value['role'] == "main"){
            $theme_id = $value['id'];
            $array = array('asset' => array('key'=>'layout/theme.liquid'));
            $assets = shopify_call($token,$shop_url,"/admin/api/2021-01/themes/".$theme_id."/assets.json",$array,'GET');
            $assets = json_decode($assets['response'],JSON_PRETTY_PRINT);
            
            
            /*Code add in layout/theme.liquid */
            $snippet = "{% include 'alertjs' %}";
            $body_tag = '</body>';
            $new_body_tag = $snippet.$body_tag;
            $theme_liquied = $assets['asset']['value'];
            $new_theme_liquied = str_replace($body_tag, $new_body_tag, $theme_liquied);
            
            /*Checking snippet add or not*/
            if(strpos($assets['asset']['value'], $new_body_tag) === false){
                
                /*Add snippet in layout/theme.liquid file before body tag*/
                $array = array('asset' => array('key'=>'layout/theme.liquid','value'=>$new_theme_liquied));
                $assets = shopify_call($token,$shop_url,"/admin/api/2021-01/themes/".$theme_id."/assets.json",$array,'PUT');
                $assets = json_decode($assets['response'],JSON_PRETTY_PRINT);
            }
            
            /*New code for snipet*/
            $codeAddtoSnippet = "<div class='informatin' ><h1>Hello world</h1>alert('Hello world')</div>";
            
            $arrayCode = array('asset'=>array("key"=>'snippets/alertjs.liquid','value'=>$codeAddtoSnippet));
            $snippetCode = shopify_call($token,$shop_url,"/admin/api/2021-01/themes/".$theme_id."/assets.json",$arrayCode,'PUT');
            $snippetCode = json_decode($snippetCode['response'],JSON_PRETTY_PRINT);
        }
    }
} 


?>