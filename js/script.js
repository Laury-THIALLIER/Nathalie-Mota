document.addEventListener("DOMContentLoaded", function () {
  // Modale de contact
  const modal = document.getElementById("contact-modal");
  const globalModal = document.getElementById("global-modal");
  const contactButton = document.getElementById("contact-nav");

  contactButton.addEventListener("click", (e) => {
    globalModal.style.display = "block";
  });

  globalModal.addEventListener("click", (event) => {
    const isClickInside = modal.contains(event.target);

    if (!isClickInside) {
      globalModal.style.display = "none";
    }
  });
});
