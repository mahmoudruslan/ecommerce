let myOffcanvas = document.getElementById("offcanvasExample");
let bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

function addToCart(productId, url) {
    let cartForm = document.getElementById("cartForm" + productId);
    let formData = new FormData(cartForm);
    url = url + "/" + productId;
    let response = ajaxRequest("POST", url, formData);
    response
        .then((response) => {
            if (response.status === true) {
                updateCartCount(response.cart.count);
                updateSubTotal(response.cart.subTotal);
            }
            return response;
        })
        .then((response) => {
            addItemInCartSidebar(response.cart.items);
            // openCartSidBar();
        });
}

// remove form cart
function removeFromCart(itemId, url)
{
    url = url + "/" + itemId;
    let response = ajaxRequest("POST", url);
    response.then((response) => {
        if (response.status === true) {
            updateCartCount(response.cart.count);
            updateSubTotal(response.cart.subTotal);
            updateTotal(response.cart.subTotal);
        }
    });
    let htmlRows = document.querySelectorAll("#cart-" + itemId);
    htmlRows.forEach((row) => {
        row.remove();
    });
    //if no products in cart show not found products in your cart
    let cartRows = document.querySelectorAll(".cart-row").length;
    if (cartRows === 0) {
        let cartDivs = document.querySelectorAll(".cart-div-main");
        cartDivs.forEach((div) => {
            let cartRow = createCartRow();
            cartRow.innerHTML = noProducts;
            div.appendChild(cartRow);
            bsOffcanvas.hide();
        });

    }
}
function createCartRow() {
    const div = document.createElement("div");
    div.setAttribute("class", "align-items-center my-4 text-center");
    return div;
}
function addItemInCartSidebar(items) {
    let cartSidebarBody = document.querySelector(".offcanvas-body");
    cartSidebarBody.innerHTML = "";
    Object.entries(items).forEach((ObjItem) => {
        let item = ObjItem[1];
        cartSidebarBody.innerHTML += `
                    <div  id="cart-${
                        item.id
                    }" class="row align-items-center cart-row">
                        <div class="col-md-4 my-4">
                            <a class="reset-anchor d-block animsition-link"
                                href="product/${item.associatedModel.slug}">
                                <img src="http\://${host}/storage/${
            item.associatedModel.first_media.file_name
        }"
                                    alt="..." width="80" /></a>
                        </div>
                        <div class="col-md-7">
                            <h6>
                                <strong class="reset-anchor animsition-link">
                                    ${item.associatedModel["name_" + lang]}
                                </strong>
                            </h6>
                            <p class="text-muted">
                                <small>${currency}</small><small id="price-${
            item.id
        }" >
                                    ${numeral(item.price).format("0,0.00")}
                                </small><br>
                            ${size} : <small>${item.size_name}</small>
                            </p>
                            <form id="cartForm${item.id}" action="">
                            <input type="hidden" class="available_quantity" id="available_quantity"
                                value="${item.associatedModel.quantity}">
                                <div class="w-75 border d-flex align-items-center justify-content-between px-3"><span
                                        class="small text-uppercase text-gray headings-font-family">${Quantity}</span>
                                    <div class="quantity">
                                        <span
                                            onclick="decreaseQuantity('${item.id}', 'http\://${host}/cart-decrease-quantity')"
                                            class="decrease p-0">
                                            <i
                                                class="px-2 fas fa-caret-${
                                                    lang === "ar"
                                                        ? "right"
                                                        : "left"
                                                }"></i></span>
                                        <input readonly name="quantity" id="quantity-${item.id}"
                                            class="bg-white form-control form-control-sm border-0 shadow-0 p-0" type="text"
                                            value="${item.quantity}" />
                                        <span
                                            onclick="increaseQuantity('${item.id}', 'http\://${host}/cart-increase-quantity')"
                                            class="increase p-0"><i
                                                class="px-2 fas fa-caret-${
                                                    lang === "ar"
                                                        ? "left"
                                                        : "right"
                                                }"></i></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1">
                            <a href="javascript:void(0)" class="reset-anchor"
                                onclick="removeFromCart('${
                                    item.id
                                }', 'http\://${host}/remove-from-cart')">
                                <i class="fas fa-trash-alt small text-muted"></i>
                            </a>
                        </div>
                        <hr class="mt-3 mb-2">
                    </div>
                    `;
                    openCartSidBar();
    });
}
function openCartSidBar() {
    let cartRows = document.querySelectorAll(".cart-row").length;
    if (cartRows === 0) {
        let el = document.querySelector(".offcanvas-body");
        el.innerHTML = `<p class="text-center">${noProducts}</p>`;
    }
    bsOffcanvas.show();
}
