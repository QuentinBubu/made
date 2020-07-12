let numberCase = 2;
const addLocation = document.getElementById("hrBreak");
const elements = [
    [
        "Température",
        "temp",
        "number"
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

let moreCase = document.getElementById("more");
moreCase.addEventListener("click", function() { moreCaseFunction(); }, false);

let lessCase = document.getElementById("less");
lessCase.addEventListener("click", function() { lessCaseFunction(); }, false);

function moreCaseFunction() {
    for (let i = 0; i <= 1; i++) {
        let a = document.createElement('hr');
        a.setAttribute("class", `inputClass${numberCase}`);
        addLocation.before(a);
    }

    for (let i = 0; i < 5; i++) {
        let newLabel = document.createElement('label');
        newLabel.textContent = elements[i][0];
        newLabel.setAttribute("for", elements[i][1].concat(numberCase));
        newLabel.setAttribute("class", `inputClass${numberCase}`);
        addLocation.before(newLabel);
        newInput = document.createElement('input');
        newInput.setAttribute("type", elements[i][2]);
        newInput.setAttribute("id", elements[i][1].concat(numberCase));
        newInput.setAttribute("class", `inputClass${numberCase}`);
        newInput.setAttribute("name", elements[i][1].concat("[]"));
        newInput.setAttribute("required", "");
        addLocation.before(newInput);
    }
    numberCase += 1;
}

function lessCaseFunction() {
    numberCase -= 1;
    document.querySelectorAll(`.inputClass${numberCase}`).forEach(function(element) {
        element.remove();
    });
}