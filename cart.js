//========================= Function to fetch and display cart items when open the cart ===========================//
function loadCartItems() {
    $.ajax({
        type: "POST",
        url: "cart_items.php",
        dataType: "html",
        success: function (data) {
            // Filling the content of the cart with the fetched data
            $('.cart').html(data);

            $.when(updateTotalPrice()).done(function () {
                console.log('Total price updated');
                setInitialShipping();
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching cart items:", status, error);
            alert("Error fetching cart items. Please try again later.");
        }


    });
}

// Call the function to fetch and display cart items, when the page loads
$(document).ready(function () {
    loadCartItems();
});

//Function to set the initial shipping price and calculate checkoutTotal
function setInitialShipping() {
    var initialShippingPrice = 0.00;
    $('#shippingOption').val('0').change();
    updateCheckoutTotal(initialShippingPrice);
}

function updateCheckoutTotal(shippingPrice) {
    var totalPrice = parseFloat($('#totalPrice').text());
    var checkoutTotal = totalPrice + shippingPrice;

    $('#checkoutTotal').text(checkoutTotal.toFixed(2));
}

//=================================== Event handler for shipping option change =====================================//
$(document).on('change', '#shippingOption', function () {
    var shippingPrice = parseInt($(this).val());
    updateCheckoutTotal(shippingPrice);
});





//========================= Function to update the quantity in the database ===========================//
function updateQuantityInDatabase(productCode, newQuantity) {
    return $.ajax({
        type: "POST",
        url: "update_quantity.php",
        data: {
            productCode: productCode,
            newQuantity: newQuantity
        },
        success: function (data) {
            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function (xhr, status, error) {
            console.error("Error updating quantity:", status, error);
        }
    });
}



//====================vent handler for quantity buttons (+ or - button in the cart view)=======================//
$(document).on('click', '.quantity', function (e) {
    e.preventDefault();

    var productCode = $(this).data('product-code');
    var quantityElement = $('.qty[data-product-code="' + productCode + '"]');
    var currentQty = parseInt(quantityElement.text());

    var newQuantity;

    if ($(this).text() === '-') {
        newQuantity = currentQty - 1;
    } else {
        newQuantity = currentQty + 1;

    }

    // Update quantity in the database
    updateQuantityInDatabase(productCode, newQuantity).done(function (data) {
        if (data === "Quantity updated successfully") {
            loadCartItems();
        } else {
            alert(data);
        }
    });
});



//========================= Function to remove the item from the database =========================//
function removeItemFromDatabase(productCode, callback) {
    $.ajax({
        type: "POST",
        url: "remove_item.php", // Create this file to handle item removal
        data: {
            productCode: productCode
        },
        success: function (data) {
            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function (xhr, status, error) {
            console.error("Error removing item:", status, error);
        }
    });
}


//================ Event handler for remove buttons (x) in  each cart item's end =============//
$(document).on('click', '.cart .close', function (e) {
    e.preventDefault();
    var productCode = $(this).closest('.cart-item').find('.qty').data('product-code');

    removeItemFromDatabase(productCode, function () {
        loadCartItems();
    });
});




//=============================== Function to update the total price =================================//
function updateTotalPrice() {
    var totalItems = 0;
    var totalPrice = 0;

    $('.cart-item').each(function () {
        var quantity = parseInt($(this).find('.qty').text());
        var price = parseFloat($(this).find('.col:last-child').text().replace('Rs.', '').replace(',', ''));

        var totalItemPrice = quantity * price;
        $(this).find('.col:last-child').text('Rs.' + totalItemPrice.toFixed(2));

        totalItems += quantity;
        totalPrice += totalItemPrice;
    });

    $('#totalItems').text(totalItems);
    $('#totalPrice').text(totalPrice.toFixed(2));

    var shippingPrice = parseInt($('#shippingOption').val());

    // Update checkoutTotal
    updateCheckoutTotal(shippingPrice);
}





//=============================== Checkout function ====================================//
function checkout() {
    var userId = $('input[name="userId"]').val();

    var itemsToCheckout = [];

    $('.cart-item').each(function () {
        var productCode = $(this).find('.qty').data('product-code');
        var selectedQty = parseInt($(this).find('.qty').text());


        if (selectedQty > 0) {
            var item = {
                productCode: productCode,
                selectedQty: selectedQty,
                userId: userId
            };

            itemsToCheckout.push(item);
        }
    });


    if (itemsToCheckout.length > 0) {
        $.ajax({
            type: "POST",
            url: "checkout.php",
            data: {
                items: JSON.stringify(itemsToCheckout)
            },
            success: function (data) {
                alert("Checkout successful!");
                // Clear the temporary cart and update the cart display
                clearTemporaryCart();
                loadCartItems();
            },
            error: function (xhr, status, error) {
                console.error("Error during checkout:", status, error);
                alert("Checkout failed. Please try again later.");
            }
        });
    } else {
        alert("No items selected for checkout.");
    }
}

//========================Function to clear the temporary cart========================//
function clearTemporaryCart() {
    $.ajax({
        type: "POST",
        url: "clear_temporary_cart.php", 
        success: function (data) {
            console.log("Temporary cart cleared.");
        },
        error: function (xhr, status, error) {
            console.error("Error clearing temporary cart:", status, error);
        }
    });
}

