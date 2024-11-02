// add to cart function with ajax with javaScript
function addToCart(withoutQuantity, productId, url) {
    // if new product => reset quantity
    if (
        parseInt(quantityIncreasedProductId) !== parseInt(productId) &&
        parseInt(quantity) !== 1
    ) {
        quantity = 1;
    }
    // resetAlert(); //to remove old classes
    document.getElementById("quantity").value =
        /* if no quantity => quantity = 1*/
        withoutQuantity.status === true ? 1 : quantity;
    let cartForm = document.getElementById("cartForm");
    let formData = new FormData(cartForm);

    url = url + "/" + productId;
    let response = ajaxRequest("POST", url, formData);
    response.then((response) => {
        if (response.status === true) {
            updateCartCount(response.cart.count);
            alert(response.title, response.type, response.message);
        }
    });
}
// remove form cart
function removeFromCart(itemId, url) {
    url = url + "/" + itemId;
    let response = ajaxRequest("POST", url);
    response.then((response) => {
        if (response.status === true) {
            updateCartCount(response.cart.count);
            updateTotals(response.cart.total, response.cart.subTotal);
        }
    });
    let htmlRow = document.querySelector("#cart-" + itemId);
    htmlRow.remove();
    //if no products in cart show not found products in your cart
    let cartRows = document.querySelectorAll(".cart-row").length;
    if (cartRows === 0) {
        tBodyEl = document.querySelector(".t-body");
        let th = createThTag();
        th.innerHTML = noProducts;
        tBodyEl.appendChild(th);
    }
}
function createThTag() {
    const th = document.createElement("th");
    th.setAttribute("class", "text-center ps-0 py-6 border-light");
    th.setAttribute("colspan", "4");
    th.setAttribute("scope", "row");
    return th;
}
function cartIncreaseQuantity(itemId, url) {
    let quantityField = document.getElementById("quantity-" + itemId); // get quantity input element
    let price = document.getElementById("price-" + itemId).innerHTML; // get product price
    let totalQuantity = document.getElementById("total-quantity-" + itemId); // get total quantity element
    quantityField.value++; //increase quantity
    let total = parseInt(quantityField.value) * parseInt(price); // quantity * price

    url = url + "/" + itemId;
    let response = ajaxRequest("POST", url);
    response.then((response) => {
            updateTotals(response.cart.total, response.cart.subTotal);

    });
    totalQuantity.innerHTML = total; // show new total
}
function cartDecreaseQuantity(itemId, url) {
    let quantityField = document.getElementById("quantity-" + itemId); // get quantity input element

    if (quantityField.value > 1) {
        let price = document.getElementById("price-" + itemId).innerHTML; // get product price
        let totalQuantity = document.getElementById("total-quantity-" + itemId); // get total quantity element
        quantityField.value--; //increase quantity
        let total = parseInt(quantityField.value) * parseInt(price); // quantity * price
        url = url + "/" + itemId;
        let response = ajaxRequest("POST", url);
        response.then((response) => {
            updateTotals(response.cart.total, response.cart.subTotal);
        });
        totalQuantity.innerHTML = total; // show new total
    }
}
