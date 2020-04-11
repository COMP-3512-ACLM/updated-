document.addEventListener("DOMContentLoaded", function () {
    const castTable = document.querySelector("#cast");
    const crewTable = document.querySelector("#crew");
    
    crewTable.style.display = "none";
    
    // Shows the selected tab
    document.querySelector("#tabs").addEventListener("click", e => {
        if (e.target.nodeName == "BUTTON") {
            if (e.target.id == "tab-cast") {
                castTable.style.display = "table";
                crewTable.style.display = "none";
            } else if (e.target.id == "tab-crew") {
                castTable.style.display = "none";
                crewTable.style.display = "table";
            }
        }
    });
    
    // Displays the lightbox
    document.querySelector("figure").addEventListener("click", () => {
        lightbox.style.display = "flex";
    });
    
    // Closes the lightbox
    document.querySelector("#lightbox").addEventListener("click", (e) => {
        if (e.target.nodeName != "IMG") {
            lightbox.style.display = "none";
        }
    });
});