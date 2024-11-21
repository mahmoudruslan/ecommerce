function profileValidation() {
    let inputs = [
        document.querySelector("#first_name"),
        document.querySelector("#last_name"),
        document.querySelector("#mobile"),
        // document.querySelector('#email'),
        document.querySelector("#username"),
    ];
    if (inputsValidation(inputs)) {
        let form = document.querySelector("#profileData");
        form.submit();
    }
}
function submitEditAddressForm(addressID) {
    if (customerAddressValidation("edit-form" + addressID)) {
        let form = document.querySelector(
            "#editCustomerAddressForm" + addressID
        );
        form.submit();
    }
}

function submitAddAddressForm() {
    if (customerAddressValidation("add-form")) {
        let form = document.querySelector("#addCustomerAddressForm");
        form.submit();
    }
}

function customerAddressValidation(formName) {
    let inputs = [
        document.forms[formName]["first_name"],
        document.forms[formName]["last_name"],
        // document.forms[formName]['email'],
        document.forms[formName]["address"],
        document.forms[formName]["mobile"],
        document.forms[formName]["governorate_id"],
        document.forms[formName]["city_id"],

        // document.querySelector('#first_name'),
        // document.querySelector('#last_name'),
        // // document.querySelector('#email'),
        // document.querySelector('#address'),
        // document.querySelector('#mobile'),
        // document.querySelector('#governorate_id'),
        // document.querySelector('#city_id'),
    ];
    return inputsValidation(inputs);
}

// window.addEventListener("click", function (event) {
//     let orderDetailDivs = document.querySelectorAll(".order-details");

//     orderDetailDivs.forEach(function (div) {
//         if(event.target != div) {
//             div.classList.add('hidden');
//         } else {
//             console.log('You clicked inside');
//         }

//     });
// });

function showOrderDetails(orderId) {
    //delete another order details divs
    let orderDetailsDivs = document.querySelectorAll(".order-details");
    orderDetailsDivs.forEach(function (div) {
        if(div != document.querySelector("#orderDetails" + orderId))div.classList.add("hidden");
    });
    document.querySelector("#orderDetails" + orderId).classList.toggle("hidden");
}
