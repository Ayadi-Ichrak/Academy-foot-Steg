let list = document.querySelectorAll(".navigation li");
let toggl = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

function activeLink() {
    // Vérifie si l'élément a déjà la classe 'active'
    if (navigation.className !== "active") {
        list.forEach((item) => {
            item.classList.remove("hovered");
        });
        this.classList.add("hovered");
    }
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

toggl.onclick = function() {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
};

function checkVisibility () { 
    const rectangle = document.getElementById("rectangle");
    if(rectangle.style.display==="block"){
    rectangle.style.display="hidden";
    }
    else
    rectangle.style.display="block";
    }
