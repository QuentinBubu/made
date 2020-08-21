//Déclaration des variables dans le scrope global
const diapo = document.getElementById("diapo");
const cross = document.getElementById("cross");
const diapoImg = document.getElementsByClassName("diapo");
const indic = document.getElementsByClassName("number");
const body = document.querySelector("body");
const timeout = 10; //secondes
let diaporama = 1;
let counter = 0;

//Définition des événement
cross.addEventListener("click", function() {
    diapo.style.display = "none";
    body.style.overflow = "auto";
}, false);

for (let i = 0; i < indic.length; i++) {
    indic[i].addEventListener("click", function() {
        actifIndic(i + 1);
    }, false);
}
window.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        diapo.style.display = "none";
        body.style.overflow = "auto";
    }
});

window.setInterval(function() { boutons(1); }, 5000);
window.setInterval(checkTime, 1000);

document.onclick = function() {
    counter = 0;
};

document.onmousemove = function() {
    counter = 0;
};

document.onkeypress = function() {
    counter = 0;
};

//Définition des fonctions
function boutons(n) {
    affichage(diaporama += n);
}

function actifIndic(n) {
    affichage(diaporama = n);
}

function affichage(n) {
    let i;
    if (n > diapoImg.length) {
        diaporama = 1;
    } else if (n < 1) {
        diaporama = diapoImg.length;
    } else {
        diaporama = n;
    }
    for (i = 0; i < diapoImg.length; i++) {
        diapoImg[i].style.opacity = "0";
    }
    for (i = 0; i < indic.length; i++) {
        indic[i].className = indic[i].className.replace(" numeros", "");
    }
    diapoImg[diaporama - 1].style.opacity = "1";
    indic[diaporama - 1].className += " numeros";
}

function checkTime() {
    counter++;
    if (counter >= timeout) {
        diapo.style.display = "block";
        body.style.overflow = "hidden";
        counter = 0;
    }
}

//Affichage de la diapositive
affichage(diaporama);