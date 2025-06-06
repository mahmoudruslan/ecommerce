let governorateSelect = document.querySelector("#governorate_id");
let shippingCostElements = document.querySelectorAll(".shippingCost");
let displayedAddress = document.querySelector("#displayed-address");
let cashOnDelivery = document.querySelector("#cash-on-delivery");
let payViaCredit = document.querySelector("#pay-via-credit");
const el = document.getElementById("expand-contract");
let shippingLi = document.querySelector("#shipping-li");
let closeModalBtn = document.querySelector("#close-modal");
let modal = document.querySelector("#add-address");

function addShippingCost(governorate_id) {
    if (governorate_id > 0) {
         let url = "add-shipping-cost/" + parseInt(governorate_id);
        let result = ajaxRequest("GET", url);
        result.then((response) => {
            updateTotal(response.cart.total);
            shippingLi.classList.remove("hidden");
            shippingCostElements.forEach((element) => {
                element.innerHTML = response.cost ? currency + numeral(response.cost).format("0,0.00") : "";
            });
        });
    }
}

if(governorateSelect){
    governorateSelect.addEventListener("change", () => {

    if ( modal == null) {
        addShippingCost(governorateSelect.value);
    }
});
}

function chooseShippingAddress(address) {
    addShippingCost(address.governorate_id);
    displayedAddress.innerHTML = address.address;
    shippingLi.classList.remove("hidden");
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

function addOrderAddress() {
    let fields = ["address", "city_id", "governorate_id", "mobile", "first_name", "last_name", "zip_code"];
    resetValidateErrors(fields);

    let form = document.querySelector("#orderForm");
    let formData = new FormData(form);
    let url = "customer-add-address";
    let response = ajaxRequest("POST", url, formData);
    response.then((data) => {
        if (data.status == true) {
            addShippingCost(data.governorate_id);
            form.reset();
            showAddresses(data.addresses);
            alert(data.title, data.type, data.message);
        } else {
            Object.entries(data.errors).forEach(([key, value]) => {
                document.querySelector("#" + key).classList.add("is-invalid");
                document.querySelector("#" + key + "_error").innerHTML = value;
            });
        }

    });
}

function showAddresses(addresses) {
    addressessDiv = document.querySelector("#alternateAddress2x");
    closeModalBtn.click();
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
        radioInput.setAttribute("name", "address_id");
        radioInput.setAttribute("value", address.id);
        radioInput.setAttribute("id", "address-" + address.id);
        radioInput.setAttribute(
            "onclick",
            `chooseShippingAddress(${JSON.stringify(address)})`
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

function calcShipping() {
    let governorate_id = governorateSelect.value;
    if (governorate_id.trim() == "") {
        addClass([governorateSelect], ["is-invalid"]);
        return;
    }
    if (governorate_id) {
        addShippingCost(governorate_id);
        shippingLi.classList.remove("hidden");
    }
}

function orderValidation() {

    let addressInput = document.querySelector('input[name="address_id"]');
    let checkedAddressInput = document.querySelector('input[name="address_id"]:checked');
    let form = document.querySelector("#orderForm");
    if(addressInput && checkedAddressInput == null)
    {
        document.querySelector('#address-id').innerHTML = chooseAddressMessage;
        window.scrollTo(0, 200);
        return ;
    }
    if (checkedAddressInput) form.submit();

    let inputs = [
    document.querySelector('#first_name'),
    document.querySelector('#last_name'),
    document.querySelector('#address'),
    document.querySelector('#mobile'),
    document.querySelector('#email'),
    document.querySelector('#governorate_id'),
    document.querySelector('#city_id'),
    ];
    if (inputsValidation(inputs)) {
        form.submit();
    }

}

