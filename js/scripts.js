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
