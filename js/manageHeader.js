var pathPage = window.location.pathname;
var page = pathPage.split('/').pop();
let pageTitle = document.getElementById("sectionTitle");

// Gestione titoli dinamici nelle pagine, recupera da input nascosto il titolo della pagina
addEventListener("DOMContentLoaded", function () {
    if (page == "index.php" || page == "") {
        let elem = document.getElementById("dynamicNav");
        if (elem !== null) {
            elem.remove();
        } else {
            console.log("L'elemento con ID 'dynamicNav' non è stato trovato.");
        }
    }
    else {
        toggleDynamicNav();
    }
});

function toggleDynamicNav() {
    let titleWithoutTags = document.createElement("div");
    titleWithoutTags.innerHTML = pageTitle.value;
    pageTitle = titleWithoutTags.textContent || titleWithoutTags.innerText || "";
    
    let header = document.getElementById("header_content");
    if (pageTitle !== null && header !== null) {
        header.innerText = pageTitle;
    } else {
        console.log("L'elemento con ID 'dynamicNav' non è stato trovato.");
    }
}