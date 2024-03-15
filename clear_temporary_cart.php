<?php

$server = "167.99.67.188";
$user = "nero";
$pw = "bD4z92R9";
$db = "neroweb";

$conn = new mysqli($server, $user, $pw, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$sqlClearCart = "TRUNCATE TABLE temporary_cart";
$conn->query($sqlClearCart);


$conn->close();

echo "Temporary cart cleared!";
