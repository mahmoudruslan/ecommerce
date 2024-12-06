var myOffcanvas = document.getElementById("offcanvasExample");
var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
// add to cart function with ajax with javaScript
function addToCart(withoutQuantity, productId, url) {
    // if new product => reset quantity
    if (
        parseInt(quantityIncreasedProductId) !== parseInt(productId) &&
        parseInt(quantity) !== 1
    ) {
        quantity = 1;
    }
    // resetAlert(); //to remove old classes
    document.getElementById("quantity").value =
        /* if no quantity => quantity = 1*/
        withoutQuantity.status === true ? 1 : quantity;
    let cartForm = document.getElementById("cartForm");
    let formData = new FormData(cartForm);

    url = url + "/" + productId;
    let response = ajaxRequest("POST", url, formData);
    response.then((response) => {
            if (response.status === true) {
                updateCartCount(response.cart.count);
                updateSubTotal(response.cart.subTotal);
                // alert(response.title, response.type, response.message);
            }
            return response.cart.items;
        }).then((items) => {
            addItemInCartSidebar(items);
            bsOffcanvas.show();
        });
}
// remove form cart
function removeFromCart(itemId, url) {
    url = url + "/" + itemId;
    let response = ajaxRequest("POST", url);
    response.then((response) => {
        if (response.status === true) {
            updateCartCount(response.cart.count);
            updateSubTotal(response.cart.subTotal);
        }
    });
    let htmlRows = document.querySelectorAll("#cart-" + itemId);
    htmlRows.forEach((row) => {
        row.remove();
        });
    //if no products in cart show not found products in your cart
    let cartRows = document.querySelectorAll(".cart-row").length;
    if (cartRows === 0) {
        bsOffcanvas.hide();
        tBodyEl = document.querySelector(".t-body");
        let th = createThTag();
        th.innerHTML = noProducts;
        tBodyEl.appendChild(th);
    }
}
function createThTag() {
    const th = document.createElement("th");
    th.setAttribute("class", "text-center ps-0 py-6 border-light");
    th.setAttribute("colspan", "4");
    th.setAttribute("scope", "row");
    return th;
}
function cartIncreaseQuantity(itemId, url) {
    let totalQuantity = document.getElementById("total-quantity-" + itemId); // get total quantity element
    let total = increaseQuantity(url, itemId);
    totalQuantity.innerHTML = currency + numeral(total).format("0,0.00"); // show new total
}
function cartDecreaseQuantity(itemId, url) {
    let totalQuantity = document.getElementById("total-quantity-" + itemId); // get total quantity element
   let total = decreaseQuantity(url, itemId);
   totalQuantity.innerHTML = currency + numeral(total).format("0,0.00"); // show new total
}
function addItemInCartSidebar(items) {

    let cartSidebarBody = document.querySelector(".offcanvas-body");
    cartSidebarBody.innerHTML = '';
    Object.entries(items).forEach((ObjItem) => {
        let item = ObjItem[1];
        cartSidebarBody.innerHTML += `
                    <div  id="cart-bar-${item.id}" class="row align-items-center my-4 cart-bar-row">
                        <div class="col-md-4">
                            <a class="reset-anchor d-block animsition-link"
                                href="product/${item.associatedModel.slug}">
                                <img src="http\://${host}/storage/${item.associatedModel.first_media.file_name}"
                                    alt="..." width="80" />
                            </a>
                        </div>
                        <div class="col-md-7">
                            <h6>
                                <strong class="reset-anchor animsition-link">
                                    ${item.associatedModel["name_"+lang]}
                                </strong>
                            </h6>
                            <p class="text-muted">
                                <small>${currency}</small><small id="price-${item.id}" >${numeral(item.price).format("0,0.00")}</small>
                            </p>
                            <form id="cartForm${item.id}" action="">
                                <div class="w-75 border d-flex align-items-center justify-content-between px-3"><span
                                        class="small text-uppercase text-gray headings-font-family">${Quantity}</span>
                                    <div class="quantity">
                                        <span
                                            onclick="cartDecreaseQuantitySidebar(${item.id}, 'http\://${ host }/cart-decrease-quantity')"
                                            class="decrease p-0">
                                            <i
                                                class="fas fa-caret-${lang === 'ar' ? 'right' : 'left'}"></i></span>
                                        <input name="quantity" id="quantity-${item.id}"
                                            class="form-control form-control-sm border-0 shadow-0 p-0" type="text"
                                            value="${ item.quantity }" />
                                        <span
                                            onclick="cartIncreaseQuantitySidebar(${item.id}, 'http\://${ host }/cart-increase-quantity')"
                                            class="increase p-0"><i
                                                class="fas fa-caret-${lang === 'ar' ? 'left' : 'right'}"></i></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1">
                            <a href="javascript:void(0)" class="reset-anchor"
                                onclick="removeFromCartBar(${item.id}, 'http\://${ host }/remove-from-cart')">
                                <i class="fas fa-trash-alt small text-muted"></i>
                            </a>
                        </div>

                    </div><hr style="margin: 0%">`;
    });



}
