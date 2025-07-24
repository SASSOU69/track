document.addEventListener("DOMContentLoaded", () => {
  const btnRecherche = document.getElementById("btnRecherche");
  const inputRecherche = document.getElementById("recherche");
  const resultatsDiv = document.getElementById("resultatsCandidatures");

  if (btnRecherche && inputRecherche && resultatsDiv) {

    const lancerRecherche = () => {
      const query = inputRecherche.value.trim();
           console.log('Recherche lancée avec mot clé:', query);
      if (!query) return;

      fetch("index.php?page=recherche&q=" + encodeURIComponent(query))
        .then(response => {
          if (!response.ok) throw new Error("Erreur serveur");
          return response.text();
        })
        .then(html => {
          resultatsDiv.innerHTML = html;
        })
        .catch(error => {
          console.error("Erreur AJAX :", error);
        });
    };

    btnRecherche.addEventListener('click', (e) => {
      e.preventDefault();
      lancerRecherche();
    });

    inputRecherche.addEventListener('keypress', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        lancerRecherche();
      }
    });

    // RECHARGE LES CANDIDATURES QUAND LE CHAMP EST VIDE
    inputRecherche.addEventListener('input', () => {
      if (inputRecherche.value.trim() === '') {
        fetch("index.php?page=candidatures")
          .then(response => response.text())
          .then(html => {
            const tempDOM = new DOMParser().parseFromString(html, "text/html");
            const contenu = tempDOM.querySelector('#resultatsCandidatures');
            if (contenu) resultatsDiv.innerHTML = contenu.innerHTML;
          });
      }
    });
  }
});
