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
//one block
let oneBlock = document.getElementById("one-block");

if (oneBlock) {
    oneBlock.addEventListener("click", function () {
        productBlocks.forEach((block) => {
            block.classList.remove("col-4", "col-6", "default-view");
            addClass([block], ["col-12"]);
        });
    });
}
//two block
let twoBlock = document.getElementById("tow-block");
if (twoBlock) {
    twoBlock.addEventListener("click", function () {
        productBlocks.forEach((block) => {
            block.classList.remove("col-4", "col-12", "default-view");
            addClass([block], ["col-6"]);
        });
    });
}
//three block
let threeBlock = document.getElementById("three-block");
if (threeBlock) {
    threeBlock.addEventListener("click", function () {
        productBlocks.forEach((block) => {
            
            block.classList.remove("col-6", "col-12", "default-view");
            addClass([block], ["col-4"]);
        });
    });
}

