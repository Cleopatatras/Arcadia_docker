document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM entièrement chargé.");

  const animalButtons = document.querySelectorAll(".increment-view");

  // if (animalButtons.length === 0) {
  //   console.warn("Aucun bouton de vue trouvé.");
  // }

  animalButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();

      const animalId = button.closest("[data-id]").getAttribute("data-id");
      const incrementUrl = button.getAttribute("data-url");
      const detailUrl = button.getAttribute("href");

      if (!animalId) {
        console.error("ID de l'animal non trouvé");
        return;
      }

      // Envoyer la requête POST pour incrémenter le compteur de vues
      fetch(`http://localhost:8088/animaux/view/${animalId}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      })
        .then((response) => {
          console.log("Réponse reçue :", response);
          if (!response.ok) {
            throw new Error(`Erreur réseau : ${response.status}`);
          }
          return response.json();
        })
        .then((data) => {
          console.log(`Nombre de vues mises à jour :`, data.views);
          // Rediriger vers la page de détail après l'incrémentation
          window.location.href = detailUrl;
        })
        .catch((error) => {
          console.error("Erreur lors de la requête :", error);
        });
    });
  });
});
