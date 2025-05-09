// Mise à jour du fichier resources/js/utils/metrics.js
// Pour une meilleure gestion des métriques avec localStorage

/**
 * Définit une métrique dans le localStorage
 * @param {string} name - Nom de la métrique (stress_level, sleep_level, grades_level)
 * @param {number} value - Valeur de la métrique
 */
export const setMetric = (name, value) => {
  // Convertir en nombre et s'assurer que la valeur est dans les limites
  const numValue = parseInt(value);
  const safeValue = Math.max(0, Math.min(10, numValue));
  localStorage.setItem(name, safeValue);
  return safeValue;
};

/**
 * Récupère une métrique du localStorage
 * @param {string} name - Nom de la métrique
 * @param {number} defaultValue - Valeur par défaut si métrique non trouvée
 * @returns {number} - Valeur numérique de la métrique
 */
export const getMetric = (name, defaultValue = 5) => {
  const value = localStorage.getItem(name);
  if (value === null) return defaultValue;
  
  const numValue = parseInt(value);
  // S'assurer que la valeur est un nombre valide
  return isNaN(numValue) ? defaultValue : numValue;
};

/**
 * Réinitialise toutes les métriques aux valeurs par défaut
 */
export const resetMetrics = () => {
  setMetric('stress_level', 3);
  setMetric('sleep_level', 7);
  setMetric('grades_level', 6);
};

/**
 * Obtient toutes les métriques en une seule fois
 * @returns {Object} - Objet contenant toutes les métriques
 */
export const getAllMetrics = () => {
  return {
    stress_level: getMetric('stress_level', 3),
    sleep_level: getMetric('sleep_level', 7),
    grades_level: getMetric('grades_level', 6)
  };
};