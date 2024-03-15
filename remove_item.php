<?php
  $server = "167.99.67.188";
  $user = "nero";
  $pw = "bD4z92R9";
  $db = "neroweb"; 

  $conn = new mysqli($server, $user, $pw, $db);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $productCode = $_POST['productCode'];


  $sql = "DELETE FROM temporary_cart WHERE product_code = '$productCode'";

  if ($conn->query($sql) === TRUE) {
    echo "Item removed successfully";
  } else {
    echo "Error removing item: " . $conn->error;
  }

  $conn->close();
 ?> 

