<?php

// Set variables for our request
$shop = $_GET['shop'];

$api_key = "47693c8d87315ebc974a1064e2674635";
$scopes = "read_orders,write_orders,read_products,write_products,read_themes,write_themes";
$redirect_uri = "https://shopifyapp.maansawebworld.com/specificationinfo/token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
exit();

