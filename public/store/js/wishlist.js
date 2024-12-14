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



    let htmlRow = document.querySelector("#wishlist-" + itemId);


    htmlRow.remove();
    //if no products in wishlist show not found products in your wishlist
    let wishlistRows = document.querySelectorAll(".wishlist-row").length;
    if (wishlistRows === 0) {
        let wishlistDiv = document.querySelector(".wishlist-div-main");
        let wishlistRow = createCartRow();
        wishlistRow.innerHTML = noWishlistProducts;
        wishlistDiv.appendChild(wishlistRow);
    }
    console.log(wishlistRows);
}
function createCartRow() {
    const div = document.createElement("div");
    div.setAttribute("class", "text-center align-items-center my-4");
    return div;
}
