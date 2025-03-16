let price = 10.00;

function increment() {
    let quantityInput = document.getElementById('quantity');
    let quantity = parseInt(quantityInput.value);
    quantityInput.value = quantity + 1;
    updateTotal();
}

function decrement() {
    let quantityInput = document.getElementById('quantity');
    let quantity = parseInt(quantityInput.value);
    if (quantity > 1) {
        quantityInput.value = quantity - 1;
        updateTotal();
    }
}
function updateQuantity(change) {
    let quantityInput = document.getElementById('quantity');
    let quantity = parseInt(quantityInput.value) + change;

    if (quantity < 1) return; // Prevent quantity from being less than 1

    quantityInput.value = quantity;
    updateTotal(quantity);
}

function updateTotal(quantity) {
    // AJAX request to update total
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "update_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById('total').innerText = xhr.responseText;
        }
    };
    xhr.send("quantity=" + quantity + "&price=" + price);
}
function updateTotal() {
    let quantity = parseInt(document.getElementById('quantity').value);
    let total = (quantity * price).toFixed(2);
    document.getElementById('total').innerText = total;
}
