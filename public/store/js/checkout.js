let governorateSelect = document.querySelector("#governorate_id");
let shippingCostElements = document.querySelectorAll(".shippingCost");
let displayedAddress = document.querySelector("#displayed-address");
let cashOnDelivery = document.querySelector("#cash-on-delivery");
let payViaCredit = document.querySelector("#pay-via-credit");
const el = document.getElementById("expand-contract");

// governorateSelect.addEventListener("change", function(e) {
//     addShippingCost(this.value);
// }, false);

function addShippingCost(governorate_id) {
    let url = "governorate-cost/" + parseInt(governorate_id);
    let result = ajaxRequest("GET", url);
    result.then((data) => {
        updateTotals(data.cart.total, data.cart.subTotal);
        shippingCostElements.forEach((element) => {
            element.innerHTML = data.cost ? data.cost : "";
        });
    });
}

function chooseAddress(address) {
    addShippingCost(address.governorate_id);
    displayedAddress.innerHTML = address.address;
}

function openCollapse() {
    addClass([payViaCredit], ["card-background"]);
    removeClass([el], ["expanded"]);
    removeClass([el], ["collapsed"]);
    removeClass([cashOnDelivery], ["card-background"]);
}

function closeCollapse() {
    addClass([el], ["expanded"]);
    addClass([el], ["collapsed"]);
    addClass([cashOnDelivery], ["card-background"]);
    removeClass([payViaCredit], ["card-background"]);
}

function addAddress() {
    let form = document.querySelector("#addAddressForm");
    // form.reset();
    let failds = [
        "address",
        "city_id",
        "governorate_id",
        "mobile",
        "first_name",
        "last_name",
        "zip_code",
    ];
    failds.forEach((field) => {
        document.querySelector("#" + field).classList.remove("is-invalid");
        let element = document.querySelector("#" + field + "_error");
        if (element) element.innerHTML = "";
    });

    let formData = new FormData(form);
    let url = "customer-add-address";
    let response = ajaxRequest("POST", url, formData);
    response.then((data) => {
        if (data.status == false) {
            Object.entries(data.errors).forEach(([key, value]) => {
                document.querySelector("#" + key).classList.add("is-invalid");
                document.querySelector("#" + key + "_error").innerHTML = value;
            });
        } else {
            addShippingCost(data.governorate_id);
            form.reset();
            showAddresses(data.addresses);
        }
    });
}

function showAddresses(addresses) {
    addressessDiv = document.querySelector("#alternateAddress2x");
    modal = document.querySelector("#close-modal");
    modal.click();
    addressessDiv.innerHTML = "";
    addresses.forEach((address) => {
        const fragment = document.createDocumentFragment();
        const addressDiv = document.createElement("div");
        const radioInput = document.createElement("input");
        const label = document.createElement("label");
        const inputVal = document.createElement("input");
        inputVal.setAttribute("id", "add-" + address);
        inputVal.setAttribute("type", "hiddent");
        addressDiv.setAttribute("id", "collapseOne");
        addressDiv.setAttribute("aria-labelledby", "headingOne");
        addressDiv.setAttribute("data-parent", "#accordion");
        addressDiv.setAttribute("class", "col-lg-6 collapse show");
        radioInput.setAttribute("checked", true);
        radioInput.setAttribute("class", "form-check-input");
        radioInput.setAttribute("type", "radio");
        radioInput.setAttribute("name", "address");
        radioInput.setAttribute("id", "address-" + address.id);
        radioInput.setAttribute(
            "onclick",
            `chooseAddress(${JSON.stringify(address)})`
        );

        label.setAttribute("class", "form-check-label text-sm text-uppercase");
        label.setAttribute("id", "address-" + address.id);
        label.textContent = `${address.address}`;

        addressDiv.appendChild(radioInput);
        addressDiv.appendChild(label);
        fragment.appendChild(addressDiv);
        addressessDiv.appendChild(fragment);
        displayedAddress.innerHTML = address.address;
    });
}
