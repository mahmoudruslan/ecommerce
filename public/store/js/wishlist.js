// add to wish list
function addToWishList(productId, url) {
    // to heart icon shading
    document
        .querySelectorAll(".add-wishlist-btn" + productId)
        .forEach((btn) => {
            addClass([btn.firstElementChild], ["bold"]);
        });
    url = url + "/" + productId;
    let response = ajaxRequest("POST", url);
    response.then((response) => {
        if (response.status === true) {
            updateWishlistCount(response.wishListCount);
            alert(response.title, response.type, response.message);
        }
    });
}
// remove form wishlist
function removeFromWishList(itemId, url) {
    url = url + "/" + itemId;
    let response = ajaxRequest("POST", url);
    response.then((response) => {
            updateWishlistCount(response.wishListCount);
    });

    // let htmlRow = document.getElementById(itemId);
    let htmlRow = document.querySelector("#wish-" + itemId);
    htmlRow.remove();

    //if no products in wishlist show not found products in your wishlist
    let wishlistRows = document.querySelectorAll(".wishlist-row").length;
    if (wishlistRows === 0) {
        tBodyEl = document.querySelector(".t-body");
        let th = createThTag();
        th.innerHTML = noProducts;
        tBodyEl.appendChild(th);
    }
}
