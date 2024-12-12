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
        console.log(input);

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
    if (valid == false) {
        window.scrollTo(0, 200);
    }
    return valid;
}
function resetValidateErrors(fields) {
    fields.forEach((field) => {
        document.querySelector("#" + field).classList.remove("is-invalid");
        let element = document.querySelector("#" + field + "_error");
        if (element) element.innerHTML = "";
    });
}
function increaseQuantity(itemId, url) {
    let quantityFields = document.querySelectorAll("#quantity-" + itemId); // get quantity input element
    quantityFields.forEach((field) => {
        field.value++;
    });
    url = url + "/" + itemId;
    let response = ajaxRequest("POST", url);
    response
        .then((response) => {
            if (response.status == false && response.message) {
                alert(response.title, response.type, response.message);
                quantityFields.forEach((field) => {
                    field.value--;
                });
            }
            return response;
        })
        .then((response) => {
            console.log(response);

            updateTotal(response.cart.total);
            updateSubTotal(response.cart.subTotal);
        });
}

function decreaseQuantity(itemId, url) {
    let decrease = false;
    let quantityFields = document.querySelectorAll("#quantity-" + itemId); // get quantity input element
    quantityFields.forEach((field) => {
        if (field.value > 1) {
            field.value--;
            decrease = true;
        }
    });
    if (decrease) {
        url = url + "/" + itemId;
        let response = ajaxRequest("POST", url);
        response.then((response) => {
            updateTotal(response.cart.total);
            updateSubTotal(response.cart.subTotal);
        });
    }
}
