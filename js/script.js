// MODALE DE CONTACT
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("contact-modal");
  const globalModal = document.getElementById("global-modal");
  const contactButton = document.querySelectorAll(".contact-nav");

  contactButton.forEach((button) => {
    button.addEventListener("click", (e) => {
      globalModal.style.display = "block";
    });

    globalModal.addEventListener("click", (event) => {
      const isClickInside = modal.contains(event.target);

      if (!isClickInside) {
        globalModal.style.display = "none";
      }
    });
  });
});

// BURGER MENU
const burgerMenu = document.getElementById("burger-menu");
const fullscreenMenu = document.getElementById("fullscreenMenu");
const burgerImg = document.getElementById("burgerImg");
const crossImg = document.getElementById("crossImg");

burgerMenu.addEventListener("click", () => {
  if (burgerMenu.classList == "activeMenu") {
    fullscreenMenu.style.display = "none";
    burgerImg.style.display = "block";
    crossImg.style.display = "none";
    burgerMenu.classList.remove("activeMenu");
  } else {
    fullscreenMenu.style.display = "block";
    burgerImg.style.display = "none";
    crossImg.style.display = "block";
    burgerMenu.classList.add("activeMenu");
  }
});

// LIGHTBOX
const lightbox = document.querySelector("#lightbox");
const closeLightbox = document.querySelector("#closeLightbox");

function lightboxMota() {
  const fullsizeImgs = document.querySelectorAll(".fullscreenImg");
  fullsizeImgs.forEach((fullsizeImg) => {
    fullsizeImg.addEventListener("click", (event) => {
      event.preventDefault();

      const img = new Image();
      img.src = fullsizeImg.parentNode.parentNode.previousElementSibling.src;
      img.style.maxWidth = "90%";
      img.style.maxHeight = "90%";

      lightbox.appendChild(img);

      lightbox.style.display = "flex";
    });
  });

  closeLightbox.addEventListener("click", () => {
    lightbox.style.display = "none";

    lightbox.removeChild(lightbox.lastChild);
  });
}

lightboxMota();
