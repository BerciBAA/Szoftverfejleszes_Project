var tabBtn = document.querySelectorAll(".tab");
var tab = document.querySelectorAll(".tabShow");
var editTab = document.querySelectorAll(".editShow");

function tabs(panelIndex){
    edit(1);
    tab.forEach(function(node){
        node.style.display = "none";

    });
    tab[panelIndex].style.display = "block";
}

function edit(panelIndex){
    editTab.forEach(function(node){
        node.style.display = "none";

    });
    editTab[panelIndex].style.display = "block";
}
edit(1)
tabs(0)