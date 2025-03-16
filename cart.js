let price = 10.00; // Example base price

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

function updateTotal() {
    let quantity = parseInt(document.getElementById('quantity').value);
    let total = (quantity * price).toFixed(2);
    document.getElementById('total').innerText = total;
}
