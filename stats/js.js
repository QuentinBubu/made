//Création d'un numéro pour l'attribution catégorie+id pour les labels
let numberCase = 2;
//Définition du point de génération des labels et inputs
const addLocation = document.getElementById("hrBreak");
//Création de éléments contenant:
const elements = [
    [
        "Température", //Le contenu du label
        "temp", //La catégorie
        "number" //Le type de l'input
    ],
    [
        "Pluie",
        "rain",
        "number"
    ],
    [
        "Vitesse du vent",
        "wind",
        "number"
    ],
    [
        "Date",
        "date",
        "date"
    ],
    [
        "Heure",
        "hour",
        "time"
    ]
];
//Création d'une constante moreCase ciblant le bouton plus
const moreCase = document.getElementById("more");
//Ajout à la liste d'événements le click qui fera appel à la fonction moreCaseFunction
moreCase.addEventListener("click", function() { moreCaseFunction(); }, false);

//Idem mais pour le bouton moins
const lessCase = document.getElementById("less");
//Idem mais pour la fonction lessCaseFunction
lessCase.addEventListener("click", function() { lessCaseFunction(); }, false);

function moreCaseFunction() {
    //Génération de 2 barre hr pour séparer les sections de labels et input
    //(Voir le CSS pour savoir pourquoi 2)
    for (let i = 0; i <= 1; i++) {
        //Création de l'élément hr
        let a = document.createElement('hr');
        //Attribution au hr de la class inputClassNumberCase pour qu'il soit supprimer lors de la suppression
        a.setAttribute("class", `inputClass${numberCase}`);
        //Ajout du hr avant le hr avec l'id hrBreak
        addLocation.before(a);
    }

    for (let i = 0; i < 5; i++) {
        //Création d'un élément label
        let newLabel = document.createElement('label');
        //Attribution du texte pour le label (voir elements)
        newLabel.textContent = elements[i][0];
        //Attribution du for pointant vers l'id de l'élément généré
        newLabel.setAttribute("for", elements[i][1].concat(numberCase));
        //Attribution de sa class pour l'élément
        newLabel.setAttribute("class", `inputClass${numberCase}`);
        //Ajout du label avant le hr avec l'id hrBreak
        addLocation.before(newLabel);
        //Création de l'input
        newInput = document.createElement('input');
        //Attribution du type (voir elements)
        newInput.setAttribute("type", elements[i][2]);
        //Attribution de son id pour le label
        newInput.setAttribute("id", elements[i][1].concat(numberCase));
        //Attribution de sa class pour sa suppression
        newInput.setAttribute("class", `inputClass${numberCase}`);
        //Attribution de son name
        //On retrouve bien les crochets pour dire qu'il ira dans un tableau
        newInput.setAttribute("name", elements[i][1].concat("[]"));
        //Attribution de l'attribut required
        newInput.setAttribute("required", "");
        //Ajout de l'input avant hrBreak
        addLocation.before(newInput);
    }
    //On incrémente de 1
    numberCase += 1;
}
/*
 * Ici nous avons utilisé des tableaux pour la génération des input,
 * Cette méthode évite de mettre 5 fois le code écris ci-dessus et donc, facilite la compréhension et est plus pratique,
 * En effect, si l'on souhaite changer un attribut, on aura à le faire une seul fois plutôt que 5
*/

function lessCaseFunction() {
    //Pour éviter de tomber dans des nombres trop bas et qui pourrai engendrer des problème, on fixe à la limite de départ
    if (numberCase > 2) {
        //Vu que précédament on a terminer sur une incrémantation, cette fois on commanence par la décrémentation pour séléctionner le dernier élément
        numberCase -= 1;
        //Séléction de tous les éléments avec la class .inputClassNumber
        document.querySelectorAll(`.inputClass${numberCase}`).forEach(function(element) {
            //Suppression de ces derniers
            element.remove();
        });
    }
}