<?php

// Get our helper functions
require_once("inc/functions.php");
include_once 'inc/sql_connection.php';

// Set variables for our request
$api_key = "47693c8d87315ebc974a1064e2674635";
$shared_secret = "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";
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically

$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {

	// Set variables for our request
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);

	// Generate access token URL
	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

	// Configure curl client and execute request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);

	// Store the access token
	$result = json_decode($result, true);
	$access_token = $result['access_token'];

	// Show the access token (don't do this in production!)
	//echo $access_token;
        
        $sql = "INSERT INTO shop (store_url, access_token, plugin install_date)
		VALUES ('".$params['shop']."', '".$access_token."', 'specification', NOW())";
        if (mysqli_query($conn, $sql)) {
                header('Location: https://'.$params['shop'].'/admin/apps');
                exit();
        } else {
                echo "Error inserting new record: " . mysqli_error($conn);
        }

} else {
	// Someone is trying to be shady!
	die('This request is NOT from Shopify!');
}