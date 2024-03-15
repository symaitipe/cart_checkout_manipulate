<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="cart.css">
</head>

<body>
    <div class="card">
        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col">
                            <h4><b>Shopping Cart</b></h4>
                        </div>
                        <div class="col align-self-center text-right text-muted">0</div>
                    </div>
                </div>

                <!-- Cart items will be dynamically generated here using PHP -->
                <?php include 'cart_items.php'; ?>

                <div class="back-to-shop"><a href="#">&leftarrow; <span class="text-muted">Back to shop</span></a></div>
            </div>
            <div class="col-md-4 summary">
                <div>
                    <h5><b>Summary</b></h5>
                </div>
                <hr>
                <div class="row">
                    <div class="col" style="padding-left:0;">ITEMS : <span id="totalItems">0</span></div>
                    <div class="col text-right">Rs.<span id="totalPrice">0.00</span></div>
                </div>
                <form>
                    <p>SHIPPING</p>
                    <select id="shippingOption">
                        
                        <option class="text-muted" value="500">Fast-Delivery- Rs.500.00</option>
                        <option class="text-muted" value="300">Standard-Delivery- Rs.300.00</option>
                    </select>
                    <div class="row">
                        USER ID: <br>
                        <input type="text" name="userId">
                    </div>
                </form>
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col">TOTAL PRICE</div>
                    <div class="col text-right">Rs.<span id="checkoutTotal">0.00</span></div>
                </div>
                <button class="btn" onclick="checkout()">CHECKOUT</button>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="./cart.js"></script>

    <script>
        // Use jQuery to perform AJAX 
        // Call the function to fetch and display cart items when the page loads
        $(document).ready(function() {
            loadCartItems();
        });
    </script>
</body>

</html>