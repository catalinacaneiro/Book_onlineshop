/* Här ska man skapa en eventlistener funktion */

const sortSelect = document.getElementById("sortselect");
if (sortSelect) {
  sortSelect.addEventListener("change", function () {
    
    const [sort, order] =
      this.value.split("-"); 

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
    let resp = await fetch(`/javascriptAddToCart?id=${productId}`);
    let data = await resp.json();
    document.getElementById('cartItemCount').innerText = data.cartItemCount;

    // document.getElementById('cartTotalPrice').innerText = data.cartTotalPrice; -> kommer att visa totala summan för alla produkter vi läller till i cart. MÅSTE VARA EVENTUELLT IF SATS 


    // const carItemsElement IF SATS 


    // 






    // fetch(`/javascriptAddToCart?id=${productId}`)
    // .then(response => response.json())
    // .then(data => {
    //         document.getElementById('cartItemCount').innerText = data.cartItemCount;
    // });
}


