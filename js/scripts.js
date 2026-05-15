/* Här ska man skapa en eventlistener funktion */


const sortSelect = document.getElementById('sortselect'); 
if (sortSelect) {
    sortSelect.addEventListener('change', function(){
        /* this.value innehåller sortering/sort och order */
        const [sort, order] = this.value.split('-'); /* split kommer att returnera en array[] */

        const urlSearchParams = new URLSearchParams(window.location.search);
        urlSearchParams.set('sort', sort); 
        urlSearchParams.set('order', order); 

        

        //alert('Slected value: ' + urlSearchParams.toString()); 
        window.location.search = urlSearchParams.toString(); 

    });
}

