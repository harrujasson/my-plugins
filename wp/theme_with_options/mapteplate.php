<?php 
/*
Template Name: Map Test
 *  */


$record =$front->getPost('igmap');
$country = $front->getMetavalue('635','map_info');        
echo "<pre>"; print_r($country); echo "</pre>"; die();
?>