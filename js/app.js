// Attendre que toute la page soit complètement chargée
window.addEventListener('load', () => {
  // Récupérer l'élément du loader par son ID (plus fiable que la classe)
  const loader = document.getElementById('loader');
  
  // Si le loader n'existe pas, on quitte
  if (!loader) return;

  // Fonction pour masquer et supprimer le loader
  const hideLoader = () => {
    // Ajouter la classe 'hidden' qui déclenche la transition CSS
    loader.classList.add('hidden');
    
    // Une fois la transition terminée, supprimer l'élément du DOM
    loader.addEventListener('transitionend', () => {
      loader.remove();
    }, { once: true }); // L'écouteur ne s'exécute qu'une seule fois
  };

  // Délai optionnel de 600 ms pour un effet visuel plus agréable
  setTimeout(hideLoader, 600);
});