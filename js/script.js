let cart = [];

function addToCart(itemId) {
    cart.push(itemId);
    alert("Item added to cart!");
}

function buyNow(itemId) {
    window.location.href = `place_order.php?itemId=${itemId}`;
}