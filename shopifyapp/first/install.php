<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = "34abc88ee26f3a13f5e179bdb6d7a0a9";
$scopes = "read_orders,write_orders,read_products,write_products,read_themes,write_themes";
$redirect_uri = "https://shopifyapp.maansawebworld.com/first/token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();