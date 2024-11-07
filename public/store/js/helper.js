let token = document.getElementsByName("csrf-token")[0].getAttribute("content");
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
function updateTotals(total, subTotal) {
    let totalEl = document.querySelector("#cart-total");
    let subTotalEl = document.querySelector("#cart-subtotal");
    totalEl.innerHTML = total;
    subTotalEl.innerHTML = subTotal;
}

function updateCartCount(cartCount) {
    document.getElementById("cart-count").innerHTML = "(" + cartCount + ")";
}
function updateWishlistCount(wishListCount) {
    document.querySelector("#wishlist-count").innerHTML =
        "(" + wishListCount + ")";
}

function updateShippingCost(data) {}

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
            document.querySelector(`#${input.name}_error`).innerHTML = requiredMessage;
            valid = false;
        } else {
            if (input.name == 'email') {
                var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                if (!input.value.match(validRegex)) {
                    input.classList.add("is-invalid");
                    document.querySelector(`#${input.name}_error`).innerHTML = emailMessage;
                    return false;
                }
            }
            input.classList.remove("is-invalid");
        }
    });
    return valid;
}

