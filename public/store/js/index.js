let quantity = 1;
//decrease quantity
document.querySelectorAll(".dec-btn").forEach((el) => {
    el.addEventListener("click", () => {
        let quantityField = el.parentElement.querySelector("#quantity");
        if (parseInt(quantityField.value, 10) > 1) {
            quantityField.value = parseInt(quantityField.value, 10) - 1;
            quantity = quantityField.value;
        }
    });
});
//increase quantity
document.querySelectorAll(".inc-btn").forEach((el) => {
    el.addEventListener("click", () => {
        let productId = el.parentElement.querySelector("#product_id").value;
        let form = document.getElementById("cartForm" + productId);
        let availableQuantitySize = form.querySelector(
            'input[name="value_id"]:checked'
        ).dataset.quantity;
        if (parseInt(quantity) < parseInt(availableQuantitySize)) {
            let quantityField = el.parentElement.querySelector("#quantity");
            // quantityIncreasedProductId =
            //     el.parentElement.querySelector("#product_id").value;
            quantityField.value = parseInt(quantityField.value, 10) + 1;
            quantity = quantityField.value;
        } else {
            alert(success, "success", maxQuantityMessage);
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

document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".star");
    const ratingValue = document.getElementById("rating-value");

    stars.forEach((star) => {
        star.addEventListener("click", function () {
            const value = this.getAttribute("data-value");

            ratingValue.value = value;

            stars.forEach((s) => {
                if (s.getAttribute("data-value") <= value) {
                    s.classList.add("fas");
                    s.classList.remove("far");
                } else {
                    s.classList.add("far");
                    s.classList.remove("fas");
                }
            });
        });
    });
});

function sendReview(slug, url) {
    const ratingValue = document.getElementById("rating-value");
    let inputs = [
        document.querySelector('input[name="first_name"]'),
        document.querySelector('input[name="last_name"]'),
        document.querySelector('input[name="email"]'),
        document.querySelector('textarea[name="body"]'),
    ];
    if (ratingValue.value == 0) {
        document.querySelector("#stars").classList.add("shake");
        setTimeout(() => {
            document.querySelector("#stars").classList.remove("shake");
        }, 250);
        return;
    }

    if (inputsValidation(inputs)) {
        url = url + "/" + slug;
        let reviewForm = document.querySelector("#reviewForm");
        let formData = new FormData(reviewForm);
        let response = ajaxRequest("POST", url, formData);
        response.then((response) => {
            if (response.message) {
                document.querySelector(".modal").click();
                alert(response.title, response.type, response.message);
                location.reload();
            }
        });
    }
}
document.addEventListener("DOMContentLoaded", () => {
    const sizeBoxes = document.querySelectorAll(".size-box");

    sizeBoxes.forEach((box) => {
        box.addEventListener("click", function () {
            const productId = this.dataset.product;

            const siblingBoxes = this.closest(".row").querySelectorAll(".size-box");
            siblingBoxes.forEach((b) => b.classList.remove("bg-primary"));
            this.classList.add("bg-primary");
            const targetId = this.dataset.target;
            const selectedSizeLabel = document.getElementById(targetId);
            selectedSizeLabel.textContent = this.textContent.trim();
            resetQuantity(productId);
        });
    });
});
function resetQuantity(productId) {
    let form = document.getElementById("cartForm" + productId);

    let quantityField = form.querySelector('input[id="quantity"]');

    quantityField.value = 1;
    quantity = 1;
}
