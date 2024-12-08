function removeFromCartBar(itemId, url)
{
    url += "/" + itemId;
    let response = ajaxRequest("POST", url);
    response.then((response) => {
        if (response.status === true) {
            updateCartCount(response.cart.count);
            updateSubTotal(response.cart.subTotal);
        }
    });
    let htmlRow = document.querySelector("#cart-bar-" + itemId);
        htmlRow.remove();
    //if no products in cart show not found products in your cart
    let cartRows = document.querySelectorAll(".cart-bar-row").length;
    if (cartRows === 0) {
        bsOffcanvas.hide();
    }
}
