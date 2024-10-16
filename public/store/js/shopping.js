//start show alerts
let toast = document.querySelector(".ajax-alert");
let progress = document.querySelector(".progress");
let token = document.getElementsByName("csrf-token")[0].getAttribute("content");

function showAlert(result) {
    let check = document.getElementById("check");
    let alertType = result.type;

    document.getElementById("title").innerHTML = result.title; //get alert title
    document.getElementById("message").innerHTML = result.message; //get alert message
    //add classes
    toast.classList.add("active");
    progress.classList.add("active");
    check.classList.add(alertType);

    //add background color to (before) progress
    let styleElem = document.head.appendChild(document.createElement("style"));
    styleElem.innerHTML =
        "#progress:before {background-color: var(--" + alertType + ")}";

    timer1 = setTimeout(() => {
        toast.classList.remove("active");
    }, 2000); //1s = 1000 milliseconds

    timer2 = setTimeout(() => {
        progress.classList.remove("active");
    }, 2500);
}
function resetAlert() {
    //to remove old classes
    toast.classList.remove("active");

    setTimeout(() => {
        progress.classList.remove("active");
    }, 300);
    check.classList.remove("success", "info", "warning", "error");
}
function clearTime() {
    //clear timer
    setTimeout(() => {
        clearTimeout(timer1);
        clearTimeout(timer2);
    }, 5000);
}
// end show alerts
// ====================================================================================

// start increase and decrease quantity functions
let quantity = 1;
let quantityIncreasedProductId = null;

//decrease quantity
document.querySelectorAll(".dec-btn").forEach((el) => {
    el.addEventListener("click", () => {
        let quantityField = el.parentElement.querySelector("#quantity");
        quantityIncreasedProductId =
            el.parentElement.querySelector("#product_id").value;

        if (parseInt(quantityField.value, 10) > 1) {
            quantityField.value = parseInt(quantityField.value, 10) - 1;
            quantity = quantityField.value;
        }
    });
});

//increase quantity
document.querySelectorAll(".inc-btn").forEach((el) => {
    el.addEventListener("click", () => {
        let availableQuantity = el.parentElement.querySelector(
            "#available_quantity"
        ).value;

        if (parseInt(quantity) < parseInt(availableQuantity)) {
            let quantityField = el.parentElement.querySelector("#quantity");
            quantityIncreasedProductId =
                el.parentElement.querySelector("#product_id").value;
            quantityField.value = parseInt(quantityField.value, 10) + 1;
            quantity = quantityField.value;
        } else {
            showAlert({
                message: maxQuantityMessage,
                status: true,
                title: success,
                type: "success",
            });
        }
    });
});

// end increase and decrease quantity functions
//===================================================================================

    document.querySelectorAll('.add-wishlist-btn').forEach((btn) => {
    btn.addEventListener("click", () => {
        btn.firstElementChild.classList.add('bold');
        
    });
});
// add to cart function with ajax with javaScript
function addToCart(withoutQuantity, productId, url)
{

  
    // if new product => reset quantity
    if ( parseInt(quantityIncreasedProductId) !== parseInt(productId) &&
        parseInt(quantity) !== 1 ) { 
        quantity = 1;
    }
    resetAlert(); //to remove old classes
    document.getElementById("quantity").value =
        /* if no quantity => quantity = 1*/ withoutQuantity.status === true
            ? 1
            : quantity;
    let cartForm = document.getElementById("cartForm");
    let formData = new FormData(cartForm);

    url = url + "/" + productId;
    ajaxRequest("POST", url, formData);
}
//===================================================================================

// add to wish list 
function addToWishList(productId, url) {
    resetAlert(); //to remove old classes
    url = url + "/" + productId;
    ajaxRequest("POST", url);
}
//===================================================================================
// remove form cart
function removeFromCart(itemId, url) {
    url = url + "/" + itemId;
    ajaxRequest("POST", url);

    let htmlRow = document.querySelector('#cart-' + itemId);
    htmlRow.remove();
}
//===================================================================================
// remove form wishlist
function removeFromWishList(itemId, url) {
    url = url + "/" + itemId;
    ajaxRequest("POST", url);

    // let htmlRow = document.getElementById(itemId);
    let htmlRow = document.querySelector('#wish-' + itemId);
    htmlRow.remove();
}

function cartIncreaseQuantity(itemId, url) {
    let quantityField = document.getElementById("quantity-" + itemId); // get quantity input element
    let price = document.getElementById("price-" + itemId).innerHTML; // get product price
    let totalQuantity = document.getElementById("total-quantity-" + itemId); // get total quantity element
    quantityField.value++; //increase quantity
    let total = parseInt(quantityField.value) * parseInt(price); // quantity * price

    url = url + "/" + itemId;
    ajaxRequest("POST", url);
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
        ajaxRequest("POST", url);
        totalQuantity.innerHTML = total; // show new total
    }
}

//===================================================================================

//update cart data
function updateCartData(result) {
    document.getElementById("cart-count").innerHTML = "(" + result.cart.count + ")";
    

    let totalEl = document.getElementById("cart-total");
    let subTotalEl = document.getElementById("cart-subtotal");

    if (totalEl != null && subTotalEl != null) {
        totalEl.innerHTML = result.cart.total;
        subTotalEl.innerHTML = result.cart.subTotal;
    }
}


// product view three block or two block
let productBlocks = document.querySelectorAll("#product-block");
//two block
let twoBlock = document.getElementById("tow-block");
twoBlock.addEventListener("click", function () {
    productBlocks.forEach((block) => {
        block.classList.remove("col-4");
        block.classList.add("col-6");
    });
});
//three block
let threeBlock = document.getElementById("three-block");
threeBlock.addEventListener("click", function () {
    productBlocks.forEach((block) => {
        block.classList.remove("col-6");
        block.classList.add("col-4");
    });
});

function ajaxRequest(method, url, formData = null) {
    let loaderDiv = document.querySelector(".loader"); // access loader div
    // loaderDiv.classList.add("loader");
    loaderDiv.style.display = 'block';
    fetch(url, {
        method: method,
        headers: {
            "x-csrf-token": token,
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (typeof data.wishListCount  != 'undefined') {
                document.querySelector("#wishlist-count").innerHTML = "(" + data.wishListCount + ")";

            }else{
                updateCartData(data);
            }
            return data;
        })
        .then((data) => {
            loaderDiv.style.display = 'none';
            if (typeof data.message != "undefined") {
                showAlert(data);
            }
        }).catch((error) => {
            loaderDiv.style.display = 'none';
            showAlert({
                message: "An error occurred while processing your request. Please try again later.",
                type: "error",
                title: 'error',
                status: true
            })
        });
}
