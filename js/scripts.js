/* Här ska man skapa en eventlistener funktion */

const sortSelect = document.getElementById("sortselect");
if (sortSelect) {
  sortSelect.addEventListener("change", function () {
    const [sort, order] = this.value.split("-");

    if (!sort || !order) {
      return;
    }

    const urlSearchParams = new URLSearchParams(window.location.search);
    urlSearchParams.set("sort", sort);
    urlSearchParams.set("order", order);
    urlSearchParams.set("page", "1");

    window.location.search = urlSearchParams.toString();
  });
}

async function addToCart(productId) {
  try {
    const resp = await fetch(`/javascriptAddToCart?id=${productId}`, {
      cache: "no-store",
      headers: {
        "Cache-Control": "no-cache",
      },
    });

    if (!resp.ok) {
      return;
    }

    const data = await resp.json();

    if (!data.success) {
      return;
    }

    const cartCountElement = document.getElementById("cartItemCount");
    if (cartCountElement && typeof data.cartItemCount !== "undefined") {
      cartCountElement.innerText = data.cartItemCount;
    }

    drawCart(data.cartItems || [], data.cartTotalPrice, data.cartItemCount);
  } catch (error) {
    console.error("addToCart failed", error);
  }

  // document.getElementById('cartTotalPrice').innerText = data.cartTotalPrice; -> kommer att visa totala summan för alla produkter vi läller till i cart. MÅSTE VARA EVENTUELLT IF SATS

  // const carItemsElement IF SATS

  //

  // fetch(`/api/addToCart.php?id=${productId}`)
  // .then(response => response.json())
  // .then(data => {
  //         document.getElementById('cartItemCount').innerText = data.cartItemCount;
  // });
}

function drawCart(cartItems, cartTotalPrice, cartItemCount) {
  const cartTotalPriceElement = document.getElementById("cartTotalPrice");
  if (cartTotalPriceElement) {
    const totalNumber = Number(cartTotalPrice || 0);
    cartTotalPriceElement.innerText = `$ ${Math.round(totalNumber)} `;
  }

  const cartCountElement = document.getElementById("cartItemCount");
  if (cartCountElement && typeof cartItemCount !== "undefined") {
    cartCountElement.innerText = cartItemCount;
  }

  const cartItemElement = document.getElementById("cartItem");
  if (!cartItemElement) {
    return;
  }

  cartItemElement.innerHTML = "";

  if (!Array.isArray(cartItems) || cartItems.length === 0) {
    cartItemElement.innerHTML =
      '<tr><td colspan="3" class="cart-empty">Your cart is empty.</td></tr>';
    return;
  }

  cartItems.forEach((cartItem) => {
    const productId = cartItem.product_id ?? cartItem.productId;
    const productTitle = cartItem.title ?? cartItem.productName ?? "Product";
    const quantity = Number(cartItem.quantity || 0);
    const imagePath = cartItem.img || "";
    const unitPrice = Number(cartItem.price ?? cartItem.productPrice ?? 0);
    const rowPrice = Number(cartItem.rowPrice ?? unitPrice * quantity);

    const imageHtml = imagePath
      ? `<img class="cart-thumb" src="${imagePath}" alt="${productTitle}">`
      : '<div class="cart-thumb cart-thumb-placeholder">No image</div>';

    cartItemElement.innerHTML += `
      <tr>
        <td>
          <div class="cart-product">
            <div class="cart-thumb-wrap">${imageHtml}</div>
            <div class="cart-product-title">${productTitle}</div>
          </div>
        </td>
        <td>
          <div class="cart-quantity">
            <a class="qty-btn" href="/removeFromCart?id=${productId}&fromPage=${encodeURIComponent(window.location.pathname + window.location.search)}" onclick="removeFromCart(${productId}); return false;" aria-label="Decrease quantity">-</a>
            <span>${quantity}</span>
            <a class="qty-btn" href="/addToCart?id=${productId}&fromPage=${encodeURIComponent(window.location.pathname + window.location.search)}" onclick="addToCart(${productId}); return false;" aria-label="Increase quantity">+</a>
          </div>
        </td>
        <td class="cart-subtotal">$ ${Math.round(rowPrice)} </td>
      </tr>
    `;
  });
}

async function fetchCartItems() {
  try {
    const resp = await fetch("/javascriptFetchCart", {
      cache: "no-store",
      headers: {
        "Cache-Control": "no-cache",
      },
    });
    const data = await resp.json();
    if (data.success) {
      drawCart(data.cartItems || [], data.cartTotalPrice, data.cartItemCount);
    }
    return data;
  } catch (error) {
    return null;
  }
}

async function removeFromCart(productId) {
  try {
    const resp = await fetch(`/javascriptRemoveFromCart?id=${productId}`, {
      cache: "no-store",
      headers: {
        "Cache-Control": "no-cache",
      },
    });

    if (!resp.ok) {
      return;
    }

    const data = await resp.json();

    if (!data.success) {
      return;
    }

    const cartCountElement = document.getElementById("cartItemCount");
    if (cartCountElement && typeof data.cartItemCount !== "undefined") {
      cartCountElement.innerText = data.cartItemCount;
    }

    drawCart(data.cartItems || [], data.cartTotalPrice, data.cartItemCount);
  } catch (error) {
    console.error("removeFromCart failed", error);
  }
}
