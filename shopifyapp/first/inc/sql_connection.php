<?php
$servername = "127.0.0.1";
$username = "maansmyb_dev_maa";
$password = "oIZoQ(=6V@!D";
$db = "maansmyb_shopify";
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
    die("Connection Error: " . mysqli_connect_error());
}