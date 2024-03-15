<?php
function getCartItemsFromDatabase() {
    $server = "167.99.67.188";
    $user = "nero";
    $pw = "bD4z92R9";
    $db = "neroweb"; 

    $conn = new mysqli($server, $user, $pw, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM temporary_cart"; // Use the correct table name of our database
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $cartItems = [];
        
        while ($row = $result->fetch_assoc()) {
        
            $cartItems[] = $row;
        }
        $conn->close();
        return $cartItems;
    } else {
        $conn->close();
        return [];
    }
}

$cartItems = getCartItemsFromDatabase();

foreach ($cartItems as $item) {
    echo '<div class="row border-top border-bottom cart-item">';
    echo '<div class="row main align-items-center">';
    echo '<div class="col-2">';
    
    if (isset($item['image'])) {
        echo '<img class="img-fluid" src="images/' . $item['image'] . '">';
    } else {
        echo 'Image Not Available';
    }

    echo '</div>';
    echo '<div class="col">';
    echo '<div class="row text-muted">' . $item['description'] . '</div>';
    echo '<div class="row">' . $item['product_code'] . '</div>';
    echo '</div>';
    echo '<div class="col">';
    echo '<a href="#" class="quantity" data-product-code="' . $item['product_code'] . '">-</a>';
    echo '<a href="#" class="border qty" data-product-code="' . $item['product_code'] . '">' . $item['selected_qty'] . '</a>';
    echo '<a href="#" class="quantity" data-product-code="' . $item['product_code'] . '">+</a>';
    echo '</div>';
    echo '<div class="col">' . 'Rs.' . number_format($item['total_price'], 2) . '<span class="close">&#10005;</span></div>';
    echo '</div>';
    echo '</div>';
}

?>