let token = document.getElementsByName("csrf-token")[0].getAttribute("content");
let lang = document.getElementsByName("lang")[0].getAttribute("value");
let host = document.getElementsByName("host")[0].getAttribute("value");
function ajaxRequest(method, url, formData = null) {
    let loaderDiv = document.querySelector(".loader"); // access loader div
    loaderDiv.style.display = "block";
    return fetch(url, {
        method: method,
        headers: {
            "x-csrf-token": token,
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            loaderDiv.style.display = "none";
            return data;
        })
        .catch((error) => {
            loaderDiv.style.display = "none";
            alert("error", error);
        });
}
function updateTotal(total) {
    let totalElements = document.querySelectorAll("#cart-total");
    totalElements.forEach((element) => {
        element.innerHTML = numeral(total).format("0,0.00");
    });
}

function updateSubTotal(subTotal) {
    let subTotalElements = document.querySelectorAll("#cart-subtotal");
    subTotalElements.forEach((element) => {
        element.innerHTML = currency + numeral(subTotal).format("0,0.00");
    });
}
function updateCartCount(cartCount) {
    document.getElementById("cart-count").innerHTML = "(" + cartCount + ")";
}
function updateWishlistCount(wishListCount) {
    document.querySelector("#wishlist-count").innerHTML =
        "(" + wishListCount + ")";
}

function addClass(elements, classes) {
    elements.forEach((element, i) => {
        element.classList.add(classes[i] ? classes[i] : classes[0]);
    });
}

function removeClass(elements, classes) {
    elements.forEach((element, i) => {
        element.classList.remove(classes[i] ? classes[i] : classes[0]);
    });
}

function inputsValidation(inputs) {
    let valid = true;
    inputs.forEach((input) => {
        if (input.value.trim() === "") {
            input.classList.add("is-invalid");
            document.querySelector(`#${input.name}_error`).innerHTML =
                requiredMessage;
            valid = false;
        } else {
            if (input.name == "email") {
                var validRegex =
                    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                if (!input.value.match(validRegex)) {
                    input.classList.add("is-invalid");
                    document.querySelector(`#${input.name}_error`).innerHTML =
                        emailMessage;
                    return false;
                }
            }
            input.classList.remove("is-invalid");
            document.querySelector(`#${input.name}_error`).innerHTML = "";
        }
    });
    return valid;
}
function resetValidateErrors(fields) {
    fields.forEach((field) => {
        document.querySelector("#" + field).classList.remove("is-invalid");
        let element = document.querySelector("#" + field + "_error");
        if (element) element.innerHTML = "";
    });
}
function increaseQuantity(url, itemId) {
    console.log('new');

    let quantityField = document.getElementById("quantity-" + itemId); // get quantity input element
    let price = document.getElementById("price-" + itemId).innerHTML; // get product price
    let totalPriceQuantity = parseInt(quantityField.value) * parseInt(numeral(price).format("00.00")); // quantity * price
    quantityField.value++; //increase quantity
    url = url + "/" + itemId;
    let response = ajaxRequest("POST", url);
    response.then((response) => {
        updateTotal(response.cart.total);
        updateSubTotal(response.cart.subTotal);
    });
    return totalPriceQuantity;

}
function decreaseQuantity(url, itemId) {
    let quantityField = document.getElementById("quantity-" + itemId); // get quantity input element
    if (quantityField.value > 1) {
        let price = document.getElementById("price-" + itemId).innerHTML; // get product price
        let total = parseInt(quantityField.value) * parseInt(numeral(price).format("00.00")); // quantity * price
        quantityField.value--; //increase quantity
        url = url + "/" + itemId;
        let response = ajaxRequest("POST", url);
        response.then((response) => {
            updateTotal(response.cart.total);
            updateSubTotal(response.cart.subTotal);
        });
        return total;
    }
}
