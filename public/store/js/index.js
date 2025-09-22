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
        let availableQuantity = form.querySelector('input[name="available_quantity"]').value;

        if (parseInt(quantity) < parseInt(availableQuantity)) {
            let quantityField = el.parentElement.querySelector("#quantity");
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
    const primaryAttributeValues = document.querySelectorAll(".primary-attribute");

    primaryAttributeValues.forEach((valueLabel) => {
        // Set initial selected value on page load
        const targetId = valueLabel.dataset.target;
        const targetSpan = document.getElementById(targetId);
        const checkedRadio = document.querySelector('input[name="primary_value_id"]:checked');
        if (checkedRadio && checkedRadio.dataset.value === valueLabel.dataset.value) {
            targetSpan.textContent = valueLabel.dataset.value;
        }

        valueLabel.addEventListener("click", function () {
            const productId = this.dataset.product;
            const siblingValues = this.closest(".row").querySelectorAll(".primary-attribute");
            siblingValues.forEach((b) => b.classList.remove("bg-primary"));
            this.classList.add("bg-primary");
            const targetId = this.dataset.target;
            const selectedValueLabel = document.getElementById(targetId);
            selectedValueLabel.textContent = this.textContent.trim();
            resetQuantity(productId);
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const secondaryAttributeValues = document.querySelectorAll(".secondary-attribute");

    secondaryAttributeValues.forEach((valueLabel) => {

         // Set initial selected value on page load
        const targetId = valueLabel.dataset.target;

        const targetSpan = document.getElementById(targetId);

        const checkedRadio = document.querySelector('input[name="secondary_value_id"]:checked');

        if (checkedRadio && checkedRadio.dataset.value === valueLabel.dataset.value) {
            targetSpan.textContent = valueLabel.dataset.value;
        }

        valueLabel.addEventListener("click", function () {
            const productId = this.dataset.product;
            const siblingValues = this.closest(".row").querySelectorAll(".secondary-attribute");
            siblingValues.forEach((b) => b.classList.remove("bg-primary"));
            this.classList.add("bg-primary");
            const targetId = this.dataset.target;
            const selectedValueLabel = document.getElementById(targetId);
            selectedValueLabel.textContent = this.textContent.trim();
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
