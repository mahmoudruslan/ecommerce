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
            alert(
                success,
                "success",
                maxQuantityMessage,
            );
        }
    });
});

// product view three block or two block
let productBlocks = document.querySelectorAll("#product-block");
//two block
let twoBlock = document.getElementById("tow-block");

if (twoBlock) {
    twoBlock.addEventListener("click", function () {
        productBlocks.forEach((block) => {
            removeClass([block], ["col-4"]);
            addClass([block], ["col-6"]);
        });
    });
}
//three block
let threeBlock = document.getElementById("three-block");
if (threeBlock) {
    threeBlock.addEventListener("click", function () {
        productBlocks.forEach((block) => {
            removeClass([block], ["col-6"]);
            addClass([block], ["col-4"]);
        });
    });
}

function cartIncreaseQuantitySidebar(itemId, url) {
    increaseQuantity(url, itemId)
}

function cartDecreaseQuantitySidebar(itemId, url) {
    decreaseQuantity(url, itemId);
}
