let removeCouponBtn = document.querySelector("#remove-coupon-btn");
let applyCouponDiv = document.querySelector("#apply-coupon-div");
let couponLi = document.querySelector("#coupon-li");
function applyCoupon(url) {
    // if input have value
    let couponField = document.querySelector("#coupon_code");
    if (couponField.value.trim() == "") {
        addClass([couponField], ["is-invalid"]);
        return;
    }
    let couponForm = document.getElementById("coupon-form");
    let formData = new FormData(couponForm);
    let response = ajaxRequest("POST", url, formData);
    response.then((result) => {
        if (result.status == true) {
            let cart = result.cart;
            updateTotals(cart.total, cart.subTotal);
            alert(result.title, result.type, result.message);
            let couponValue = document.querySelector("#coupon-value");
            addClass([applyCouponDiv], ["hidden"]);
            removeClass([removeCouponBtn, couponLi], ["hidden"]);
            couponValue.innerHTML = cart.sale;
        }else{
            alert(result.title, result.type, result.message);
        }
    });
}
function removeCoupon(url) {
    let response = ajaxRequest("POST", url);
    response.then((result) => {
            updateTotals(result.cart.total, result.cart.subTotal);
            alert(result.title, result.type, result.message);
        });
    removeClass([applyCouponDiv], ["hidden"]);
    addClass([removeCouponBtn, couponLi], ["hidden"]);
}
